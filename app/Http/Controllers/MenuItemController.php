<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'staff') {
            $allItems  = MenuItem::orderBy('category')->orderBy('name')->get();
            $menuItems = $allItems;
            $menuCount = MenuItem::where('is_available', 1)->count();

            $todayOrders   = Order::whereDate('created_at', today())->count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $todayRevenue  = Order::whereDate('created_at', today())
                                  ->where('status', 'completed')
                                  ->sum('total_amount');
            $liveOrders    = Order::with(['orderItems.menuItem', 'user', 'payment'])
                                  ->whereDate('created_at', today())
                                  ->orderByDesc('created_at')
                                  ->take(10)
                                  ->get();

            return view('staff.dashboard', compact(
                'menuItems', 'menuCount',
                'todayOrders', 'pendingOrders', 'todayRevenue', 'liveOrders'
            ));
        }

        // Customer-facing: only available items
        $menuItems = MenuItem::where('is_available', true)
                        ->orderBy('category')->orderBy('name')
                        ->get()->groupBy('category');

        $cart = null;
        if (auth()->check()) {
            $cart = Order::where('user_id', auth()->id())
                        ->where('status', 'pending')
                        ->whereDoesntHave('payment')
                        ->latest()->first();
        }

        return view('menu.index', compact('menuItems', 'cart'));
    }

    public function create()
    {
        return view('staff.menu-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'brew-and-bean/menu-items']
            );
            $validated['image'] = $result['secure_url'];
        }

        $validated['is_available'] = $request->has('is_available');
        MenuItem::create($validated);

        return redirect()->route('staff.dashboard')->with('success', 'Menu item created.');
    }

    public function edit(MenuItem $menuItem)
    {
        return view('staff.menu-form', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'brew-and-bean/menu-items']
            );
            $validated['image'] = $result['secure_url'];
        }

        // $request->has() returns false when checkbox is unchecked (not sent)
        $validated['is_available'] = $request->has('is_available');

        $menuItem->update($validated);

        return redirect()->route('staff.dashboard')->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('staff.dashboard')->with('success', 'Menu item deleted.');
    }

    public function show(MenuItem $menuItem)
    {
        return view('menu.show', compact('menuItem'));
    }
}