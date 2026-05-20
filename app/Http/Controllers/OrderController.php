<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // -------------------------------------------------------------------------
    // CUSTOMER SIDE
    // -------------------------------------------------------------------------

    /**
     * Show the menu to browse and add items.
     * Route: GET /orders/create  (orders.create)
     */
    public function create()
    {
        $menuItems = MenuItem::available()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $cart = $this->getCart();

        return view('menu.index', compact('menuItems', 'cart'));
    }

    /**
     * Add item to cart (creates cart if needed) with 15% discount.
     * Route: POST /orders/items/add  (order-items.store)
     */
    public function store(Request $request)
    {
        $cart = $this->getOrCreateCart();

        if ($request->filled('menu_item_id')) {
            $menuItem = MenuItem::findOrFail($request->menu_item_id);
            $qty      = (int) $request->input('quantity', 1);

            $existing = $cart->orderItems()->where('menu_item_id', $menuItem->id)->first();
            if ($existing) {
                $newQty = $existing->quantity + $qty;
                $existing->update([
                    'quantity' => $newQty,
                    'subtotal' => $menuItem->price * $newQty,
                ]);
            } else {
                $cart->orderItems()->create([
                    'menu_item_id' => $menuItem->id,
                    'quantity'     => $qty,
                    'unit_price'   => $menuItem->price,
                    'subtotal'     => $menuItem->price * $qty,
                ]);
            }

            $subtotal       = $cart->orderItems()->sum('subtotal');
            $discountAmount = round($subtotal * 0.15, 2);

            $cart->update([
                'total_amount'    => $subtotal - $discountAmount,
                'discount_amount' => $discountAmount,
            ]);
        }

        return redirect()->route('orders.cart')->with('success', 'Item added to cart!');
    }

    /**
     * Show the customer's current cart.
     * Route: GET /cart  (orders.cart)
     */
    public function cart()
    {
        $cart       = $this->getCart();
        $order      = $cart;
        $orderItems = $cart ? $cart->orderItems : collect();
        $subtotal   = $cart ? ($cart->total_amount + $cart->discount_amount) : 0;
        $discount   = $cart ? $cart->discount_amount : 0;
        $total      = $cart ? $cart->total_amount : 0;

        return view('orders.cart', compact('cart', 'order', 'orderItems', 'subtotal', 'discount', 'total'));
    }

    /**
     * Confirm the order — locks it and creates a pending payment.
     * Route: POST /orders/{order}/confirm  (orders.confirm)
     */
    public function confirm(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($order->isPending(), 403, 'Order is already confirmed.');
        abort_unless(! $order->payment()->exists(), 403, 'Order already has a payment.');
        abort_unless($order->orderItems()->count() > 0, 422, 'Your cart is empty.');

        DB::transaction(function () use ($request, $order) {
            Payment::create([
                'order_id' => $order->id,
                'amount'   => $order->total_amount,
                'method'   => $request->payment_method,
                'status'   => 'pending',
            ]);
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order placed! Please wait for staff to process it.');
    }

    /**
     * Show a single order (receipt / confirmation page).
     * Route: GET /orders/{order}  (orders.show)
     */
    public function show(Order $order)
    {
        // Allow staff to view any order, customers only their own
        if (Auth::user()->role === 'customer') {
            abort_unless($order->user_id === Auth::id(), 403);
        }

        $order->load('orderItems.menuItem', 'payment');

        return view('orders.show', compact('order'));
    }

    /**
     * Customer's order history.
     * Route: GET /orders  (orders.index)
     */
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('orderItems.menuItem', 'payment')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // -------------------------------------------------------------------------
    // WALK-IN SIDE (no login needed)
    // -------------------------------------------------------------------------

    /**
     * Show menu for walk-in customers.
     * Route: GET /walkin  (walkin.menu)
     */
    public function walkinMenu()
    {
        $menuItems = MenuItem::available()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $cartId = session('walkin_cart_id');
        $cart   = $cartId ? Order::find($cartId) : null;

        return view('walkin.menu', compact('menuItems', 'cart'));
    }

    /**
     * Add item to walk-in cart (session-based, no discount).
     * Route: POST /walkin/order  (walkin.store)
     */
    public function walkinStore(Request $request)
    {
        $cartId = session('walkin_cart_id');
        $cart   = $cartId ? Order::find($cartId) : null;

        if (! $cart) {
            $cart = Order::create([
                'user_id'         => null,
                'is_walkin'       => true,
                'total_amount'    => 0,
                'discount_amount' => 0,
                'status'          => 'pending',
            ]);
            session(['walkin_cart_id' => $cart->id]);
        }

        if ($request->filled('menu_item_id')) {
            $menuItem = MenuItem::findOrFail($request->menu_item_id);
            $qty      = (int) $request->input('quantity', 1);

            $existing = $cart->orderItems()->where('menu_item_id', $menuItem->id)->first();
            if ($existing) {
                $newQty = $existing->quantity + $qty;
                $existing->update([
                    'quantity' => $newQty,
                    'subtotal' => $menuItem->price * $newQty,
                ]);
            } else {
                $cart->orderItems()->create([
                    'menu_item_id' => $menuItem->id,
                    'quantity'     => $qty,
                    'unit_price'   => $menuItem->price,
                    'subtotal'     => $menuItem->price * $qty,
                ]);
            }

            $subtotal = $cart->orderItems()->sum('subtotal');
            $cart->update([
                'total_amount'    => $subtotal,
                'discount_amount' => 0, // no discount for walk-in
            ]);
        }

        return redirect()->route('walkin.cart')->with('success', 'Item added!');
    }

    /**
     * Show walk-in cart.
     * Route: GET /walkin/cart  (walkin.cart)
     */
    public function walkinCart()
    {
        $cartId     = session('walkin_cart_id');
        $cart       = $cartId ? Order::with('orderItems.menuItem')->find($cartId) : null;
        $order      = $cart;
        $orderItems = $cart ? $cart->orderItems : collect();
        $subtotal   = $cart ? $cart->total_amount : 0;
        $discount   = 0;
        $total      = $subtotal;

        return view('walkin.cart', compact('order', 'orderItems', 'subtotal', 'discount', 'total'));
    }

    /**
     * Show walk-in checkout form (enter name + payment method).
     * Route: GET /walkin/checkout  (walkin.checkout)
     */
    public function walkinCheckout()
    {
        $cartId = session('walkin_cart_id');
        $cart   = $cartId ? Order::with('orderItems.menuItem')->find($cartId) : null;

        if (! $cart || $cart->orderItems->isEmpty()) {
            return redirect()->route('walkin.menu')->with('info', 'Your cart is empty.');
        }

        return view('walkin.checkout', compact('cart'));
    }

    /**
     * Process walk-in checkout.
     * Route: POST /walkin/checkout  (walkin.checkout.store)
     */
    public function walkinCheckoutStore(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        $cartId = session('walkin_cart_id');
        $cart   = Order::with('orderItems.menuItem')->findOrFail($cartId);

        DB::transaction(function () use ($request, $cart) {
            $cart->update([
                'customer_name' => $request->customer_name,
                'status'        => 'pending',
            ]);

            Payment::create([
                'order_id' => $cart->id,
                'amount'   => $cart->total_amount,
                'method'   => $request->payment_method,
                'status'   => 'pending',
            ]);
        });

        session()->forget('walkin_cart_id');

        return view('walkin.success', ['cart' => $cart]);
    }

    // -------------------------------------------------------------------------
    // STAFF SIDE
    // -------------------------------------------------------------------------

    /**
     * Staff dashboard.
     * Route: GET /staff/dashboard  (staff.dashboard)
     */
    public function staffDashboard()
{
    $liveOrders = Order::with('user', 'orderItems.menuItem', 'payment')
        ->where('status', 'pending')
        ->whereHas('payment')
        ->latest()
        ->get();

    $todayOrders = Order::whereDate('created_at', today())
        ->whereHas('payment')  // ← only count real confirmed orders
        ->count();

    $pendingOrders = Order::where('status', 'pending')
        ->whereHas('payment')
        ->count();

    $todayRevenue = Payment::where('status', 'paid')
        ->whereDate('created_at', today())
        ->sum('amount');

    $menuCount = MenuItem::count();
    $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();

    return view('staff.dashboard', compact(
        'liveOrders',
        'todayOrders',
        'pendingOrders',
        'todayRevenue',
        'menuCount',
        'menuItems'
    ));
}

    /**
     * Staff: list all orders.
     * Route: GET /staff/orders  (staff.orders.index)
     */
    public function staffIndex(Request $request)
    {
        $orders = Order::with('user', 'orderItems.menuItem', 'payment')
            ->whereHas('payment')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(20);

        return view('staff.orders.index', compact('orders'));
    }

    /**
     * Staff: update order status.
     * Route: PATCH /staff/orders/{order}/status  (staff.orders.updateStatus)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update(['status' => $request->status]);

            if ($request->status === 'completed') {
                $order->payment?->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);
            }
        });

        return back()->with('success', "Order #{$order->id} updated to {$request->status}.");
    }

    // -------------------------------------------------------------------------
    // HELPERS
    // -------------------------------------------------------------------------

    private function getCart(): ?Order
    {
        return Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereDoesntHave('payment')
            ->with('orderItems.menuItem')
            ->latest()
            ->first();
    }

    private function getOrCreateCart(): Order
    {
        return $this->getCart() ?? Order::create([
            'user_id'         => Auth::id(),
            'is_walkin'       => false,
            'total_amount'    => 0,
            'discount_amount' => 0,
            'status'          => 'pending',
        ]);
    }
}