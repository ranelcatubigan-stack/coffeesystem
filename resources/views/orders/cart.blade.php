@extends('layouts.app')

@section('title', 'Your Cart')

@push('styles')
<style>
    .cart-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 3rem 3rem 5rem;
    }

    .page-header {
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.1s forwards;
    }
    .page-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--caramel);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-eyebrow::before {
        content: '';
        display: block;
        width: 28px; height: 1px;
        background: var(--caramel);
    }
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 4vw, 3rem);
        font-weight: 300;
        color: var(--oat);
    }
    .page-title em { font-style: italic; font-weight: 600; color: var(--caramel); }

    .cart-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }

    .cart-item {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.09);
        border-radius: 14px;
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        transition: border-color 0.2s;
    }
    .cart-item:hover { border-color: rgba(181,118,42,0.2); }

    .cart-item-img {
        width: 64px; height: 64px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        filter: brightness(0.85);
    }

    .cart-item-info { flex: 1; }
    .cart-item-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.2rem;
    }
    .cart-item-unit {
        font-size: 0.8rem;
        color: rgba(242,234,216,0.4);
    }

    .cart-item-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .qty-stepper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .qty-btn {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1px solid rgba(242,234,216,0.18);
        background: transparent;
        color: var(--oat);
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
    }
    .qty-btn:hover {
        background: rgba(181,118,42,0.2);
        border-color: var(--caramel);
    }
    .qty-num {
        font-size: 0.95rem;
        min-width: 22px;
        text-align: center;
        color: var(--oat);
    }

    .cart-item-subtotal {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--caramel);
        min-width: 80px;
        text-align: right;
    }

    .remove-btn {
        background: none;
        border: none;
        color: rgba(242,234,216,0.25);
        font-size: 1.1rem;
        cursor: pointer;
        transition: color 0.2s;
        padding: 0.2rem;
    }
    .remove-btn:hover { color: #e07070; }

    .cart-summary {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.1);
        border-radius: 18px;
        padding: 1.8rem 2rem;
        opacity: 0;
        animation: fade-up 0.7s 0.35s forwards;
    }

    .summary-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 1.2rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(242,234,216,0.08);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: rgba(242,234,216,0.6);
        margin-bottom: 0.6rem;
    }

    .summary-divider {
        height: 1px;
        background: rgba(242,234,216,0.08);
        margin: 1rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .total-label {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--oat);
    }
    .total-amount {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--caramel);
    }

    .checkout-btn {
        width: 100%;
        background: var(--caramel);
        color: var(--espresso);
        border: none;
        padding: 1rem 2rem;
        border-radius: 999px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        text-align: center;
        display: block;
        text-decoration: none;
    }
    .checkout-btn:hover {
        background: #c98830;
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(181,118,42,0.35);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 1rem;
        font-size: 0.8rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: rgba(242,234,216,0.35);
        text-decoration: none;
        transition: color 0.2s;
        width: 100%;
        justify-content: center;
    }
    .back-link:hover { color: var(--oat); }

    .empty-cart {
        text-align: center;
        padding: 5rem 2rem;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }
    .empty-cart-icon { font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.4; }
    .empty-cart h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 300;
        color: rgba(242,234,216,0.5);
        margin-bottom: 0.5rem;
    }
    .empty-cart p { font-size: 0.85rem; color: rgba(242,234,216,0.3); margin-bottom: 2rem; }

    @media (max-width: 768px) {
        .cart-page { padding: 2rem 1.5rem 4rem; }
        .cart-item { flex-wrap: wrap; gap: 0.8rem; }
        .cart-item-right { width: 100%; justify-content: flex-end; }
    }
</style>
@endpush

@section('content')

<div class="cart-page">
    <div class="page-header">
        <p class="page-eyebrow">Review before checkout</p>
        <h1 class="page-title">Your <em>Cart</em></h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if(isset($cart) && $cart->orderItems->count() > 0)

        <div class="cart-list">
            @foreach($cart->orderItems as $item)
            <div class="cart-item">
                @if($item->menuItem->image)
                    <img class="cart-item-img"
                         src="{{ str_starts_with($item->menuItem->image ?? '', 'http') ? $item->menuItem->image : asset('storage/' . $item->menuItem->image) }}"
                         alt="{{ $item->menuItem->name }}">
                @else
                    <img class="cart-item-img"
                         src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=200&q=80"
                         alt="{{ $item->menuItem->name }}">
                @endif

                <div class="cart-item-info">
                    <p class="cart-item-name">{{ $item->menuItem->name }}</p>
                    <p class="cart-item-unit">₱{{ number_format($item->unit_price, 2) }} each</p>
                </div>

                <div class="cart-item-right">
                    <div class="qty-stepper">
                        <form action="{{ route('order-items.update', [$cart->id, $item->id]) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                            <button type="submit" class="qty-btn" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                        </form>

                        <span class="qty-num">{{ $item->quantity }}</span>

                        <form action="{{ route('order-items.update', [$cart->id, $item->id]) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                            <button type="submit" class="qty-btn">+</button>
                        </form>
                    </div>

                    <span class="cart-item-subtotal">₱{{ number_format($item->subtotal, 2) }}</span>

                    <form action="{{ route('order-items.destroy', [$cart->id, $item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="remove-btn" title="Remove">✕</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <p class="summary-title">Order Summary</p>

            @foreach($cart->orderItems as $item)
                <div class="summary-row">
                    <span>{{ $item->menuItem->name }} × {{ $item->quantity }}</span>
                    <span>₱{{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach

            <div class="summary-divider"></div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span>₱{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary-row" style="color:#90d890;">
                <span style="display:flex;align-items:center;gap:.4rem;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Member discount (15%)
                </span>
                <span>− ₱{{ number_format($discount, 2) }}</span>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-total">
                <span class="total-label">Total</span>
                <span class="total-amount">₱{{ number_format($total, 2) }}</span>
            </div>

            <form action="{{ route('orders.confirm', $cart->id) }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method" value="cash">
                <div style="display:flex;gap:0.6rem;margin-bottom:0.75rem;">
                    <button type="button" onclick="selectPayment('cash')" id="pay-cash"
                        style="flex:1;padding:0.75rem;border-radius:12px;border:1px solid rgba(181,118,42,0.5);background:rgba(181,118,42,0.15);color:var(--oat);font-family:'DM Sans',sans-serif;font-size:0.8rem;cursor:pointer;transition:all 0.2s;">
                        Cash
                    </button>
                    <button type="button" onclick="selectPayment('gcash')" id="pay-gcash"
                        style="flex:1;padding:0.75rem;border-radius:12px;border:1px solid rgba(242,234,216,0.12);background:rgba(242,234,216,0.04);color:rgba(242,234,216,0.5);font-family:'DM Sans',sans-serif;font-size:0.8rem;cursor:pointer;transition:all 0.2s;">
                        GCash
                    </button>
                    <button type="button" onclick="selectPayment('card')" id="pay-card"
                        style="flex:1;padding:0.75rem;border-radius:12px;border:1px solid rgba(242,234,216,0.12);background:rgba(242,234,216,0.04);color:rgba(242,234,216,0.5);font-family:'DM Sans',sans-serif;font-size:0.8rem;cursor:pointer;transition:all 0.2s;">
                        Card
                    </button>
                </div>
                <button type="submit" class="checkout-btn">Place Order &rarr;</button>
            </form>

            <a href="{{ route('orders.create') }}" class="back-link">&larr; Add more items</a>
        </div>

    @else
        <div class="empty-cart">
            <h3>Your cart is empty</h3>
            <p>Browse the menu and add your favourite drinks.</p>
            <a href="{{ route('orders.create') }}" class="checkout-btn" style="max-width:200px;margin:0 auto;">Go to Menu</a>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function selectPayment(method) {
    document.getElementById('payment_method').value = method;
    ['cash','gcash','card'].forEach(m => {
        const btn = document.getElementById('pay-' + m);
        if (m === method) {
            btn.style.border = '1px solid rgba(181,118,42,0.5)';
            btn.style.background = 'rgba(181,118,42,0.15)';
            btn.style.color = 'var(--oat)';
        } else {
            btn.style.border = '1px solid rgba(242,234,216,0.12)';
            btn.style.background = 'rgba(242,234,216,0.04)';
            btn.style.color = 'rgba(242,234,216,0.5)';
        }
    });
}
</script>
@endpush