<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity'     => 'required|integer|min:1|max:99',
        ]);

        $menuItem = MenuItem::available()->findOrFail($request->menu_item_id);

        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereDoesntHave('payment')
            ->latest()
            ->first()
            ?? Order::create([
                'user_id'         => Auth::id(),
                'is_walkin'       => false,
                'total_amount'    => 0.00,
                'discount_amount' => 0.00,
                'status'          => 'pending',
            ]);

        $existing = $order->orderItems()->where('menu_item_id', $menuItem->id)->first();

        if ($existing) {
            $newQty = $existing->quantity + $request->quantity;
            $existing->update([
                'quantity' => $newQty,
                'subtotal' => $menuItem->price * $newQty,
            ]);
        } else {
            $order->orderItems()->create([
                'menu_item_id' => $menuItem->id,
                'quantity'     => $request->quantity,
                'unit_price'   => $menuItem->price,
                'subtotal'     => $menuItem->price * $request->quantity,
            ]);
        }

        $subtotal       = $order->orderItems()->sum('subtotal');
        $discountAmount = round($subtotal * 0.15, 2);
        $order->update([
            'total_amount'    => $subtotal - $discountAmount,
            'discount_amount' => $discountAmount,
        ]);

        return redirect()->route('orders.cart')->with('success', "\"{$menuItem->name}\" added to cart.");
    }

    public function update(Request $request, Order $order, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless(! $order->payment()->exists(), 403, 'Order already confirmed.');

        $orderItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $orderItem->unit_price * $request->quantity,
        ]);

        $subtotal       = $order->orderItems()->sum('subtotal');
        $discountAmount = round($subtotal * 0.15, 2);
        $order->update([
            'total_amount'    => $subtotal - $discountAmount,
            'discount_amount' => $discountAmount,
        ]);

        return back()->with('success', 'Quantity updated.');
    }

    public function destroy(Order $order, OrderItem $orderItem)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless(! $order->payment()->exists(), 403, 'Order already confirmed.');

        $orderItem->delete();

        $subtotal       = $order->orderItems()->sum('subtotal');
        $discountAmount = round($subtotal * 0.15, 2);
        $order->update([
            'total_amount'    => $subtotal - $discountAmount,
            'discount_amount' => $discountAmount,
        ]);

        if ($order->orderItems()->count() === 0) {
            $order->delete();
            return redirect()->route('orders.create')->with('info', 'Your cart is now empty.');
        }

        return back()->with('success', 'Item removed.');
    }

    // -------------------------------------------------------------------------
    // WALK-IN SIDE
    // -------------------------------------------------------------------------

    public function walkinUpdate(Request $request, Order $order, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $orderItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $orderItem->unit_price * $request->quantity,
        ]);

        $subtotal = $order->orderItems()->sum('subtotal');
        $order->update([
            'total_amount'    => $subtotal,
            'discount_amount' => 0,
        ]);

        return back()->with('success', 'Quantity updated.');
    }

    public function walkinDestroy(Order $order, OrderItem $orderItem)
    {
        $orderItem->delete();

        $subtotal = $order->orderItems()->sum('subtotal');
        $order->update([
            'total_amount'    => $subtotal,
            'discount_amount' => 0,
        ]);

        if ($order->orderItems()->count() === 0) {
            $order->delete();
            session()->forget('walkin_cart_id');
            return redirect()->route('walkin.menu')->with('info', 'Your cart is now empty.');
        }

        return back()->with('success', 'Item removed.');
    }

    public function index(Order $order)
    {
        $order->load('orderItems.menuItem');

        return view('staff.orders.show', compact('order'));
    }
}