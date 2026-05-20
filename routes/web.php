<?php

use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────
// Public Routes (Guests)
// ─────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuItemController::class, 'index'])->name('menu.index');
Route::get('/menu/{menuItem}', [MenuItemController::class, 'show'])->name('menu.show');

// ── Walk-in Routes (no login needed) ──
Route::get('/walkin', [OrderController::class, 'walkinMenu'])->name('walkin.menu');
Route::post('/walkin/order', [OrderController::class, 'walkinStore'])->name('walkin.store');
Route::post('/walkin/cart/{order}/items', [OrderItemController::class, 'store'])->name('walkin.items.store');
Route::patch('/walkin/cart/{order}/items/{orderItem}', [OrderItemController::class, 'walkinUpdate'])->name('walkin.items.update');
Route::delete('/walkin/cart/{order}/items/{orderItem}', [OrderItemController::class, 'walkinDestroy'])->name('walkin.items.destroy');
Route::get('/walkin/cart', [OrderController::class, 'walkinCart'])->name('walkin.cart');
Route::get('/walkin/checkout', [OrderController::class, 'walkinCheckout'])->name('walkin.checkout');
Route::post('/walkin/checkout', [OrderController::class, 'walkinCheckoutStore'])->name('walkin.checkout.store');


// ─────────────────────────────────────────────
// Authenticated Customer Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {

    Route::get('/home', function () {
        $menuCount = \App\Models\MenuItem::count();
        return view('home', compact('menuCount'));
    })->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Confirm order (replaces old orders.store — no longer needs a separate store)
    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');

    // Cart
    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');

    // Order Items — store no longer needs {order} in the URL
    Route::post('/orders/items/add', [OrderItemController::class, 'store'])->name('order-items.store');
    Route::patch('/orders/{order}/items/{orderItem}', [OrderItemController::class, 'update'])->name('order-items.update');
    Route::delete('/orders/{order}/items/{orderItem}', [OrderItemController::class, 'destroy'])->name('order-items.destroy');

    // Payment
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payment.store');

});


// ─────────────────────────────────────────────
// Authenticated Staff Routes
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    Route::get('/dashboard', [OrderController::class, 'staffDashboard'])->name('dashboard');

    // Menu Items — /menu/create MUST come before /menu/{menuItem}
    Route::get('/menu', [MenuItemController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuItemController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuItemController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menuItem}', [MenuItemController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu.edit');
    Route::patch('/menu/{menuItem}', [MenuItemController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'staffIndex'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Order Items (read-only)
    Route::get('/orders/{order}/items', [OrderItemController::class, 'index'])->name('order-items.index');

    // Payments (read-only)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');

});


// ─────────────────────────────────────────────
// Auth Routes
// ─────────────────────────────────────────────

require __DIR__ . '/auth.php';