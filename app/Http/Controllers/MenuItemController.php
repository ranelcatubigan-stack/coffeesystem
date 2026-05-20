<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')
            ->get()
            ->groupBy('category');

        if (auth()->check() && auth()->user()->role === 'staff') {
            $menuCount = $menuItems->flatten()->count();
            return view('staff.dashboard', compact('menuItems', 'menuCount'));
        }

        $cart = null;
        if (auth()->check()) {
            $cart = Order::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->whereDoesntHave('payment')
                ->latest()
                ->first();
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
            'is_available' => 'boolean',
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

        $validated['is_available'] = $request->boolean('is_available', true);
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
            'is_available' => 'boolean',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $uploaded = cloudinary()->upload($request->file('image')->getRealPath(), [
                'folder' => 'brew-and-bean/menu-items',
            ]);
            $validated['image'] = $uploaded->getSecurePath();
        }

        $validated['is_available'] = $request->boolean('is_available');
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