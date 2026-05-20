@extends('layouts.app')

@section('title', 'Payment')

@push('styles')
<style>
    .payment-page {
        max-width: 640px;
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

    /* ── Order summary card ── */
    .order-card {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.1);
        border-radius: 18px;
        padding: 1.8rem 2rem;
        margin-bottom: 1.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }

    .order-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: rgba(242,234,216,0.5);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.75rem;
        margin-bottom: 1rem;
    }

    .order-line {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        color: rgba(242,234,216,0.6);
        margin-bottom: 0.55rem;
    }
    .order-line-name { color: var(--oat); }

    .order-divider {
        height: 1px;
        background: rgba(242,234,216,0.08);
        margin: 1rem 0;
    }

    .order-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-total-label {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        color: var(--oat);
    }
    .order-total-amount {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--caramel);
    }

    /* ── Pay button ── */
    .pay-section {
        opacity: 0;
        animation: fade-up 0.7s 0.35s forwards;
    }

    .pay-btn {
        width: 100%;
        background: var(--caramel);
        color: var(--espresso);
        border: none;
        padding: 1.1rem 2rem;
        border-radius: 999px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        margin-bottom: 1rem;
    }
    .pay-btn:hover {
        background: #c98830;
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(181,118,42,0.35);
    }

    .pay-note {
        text-align: center;
        font-size: 0.78rem;
        color: rgba(242,234,216,0.3);
        letter-spacing: 0.04em;
        margin-bottom: 0.5rem;
    }

    /* ── Status screens ── */
    .status-card {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.1);
        border-radius: 20px;
        padding: 3rem 2.5rem;
        text-align: center;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }

    .status-icon {
        font-size: 3.5rem;
        margin-bottom: 1.2rem;
        display: block;
    }

    .status-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.5rem;
    }

    .status-desc {
        font-size: 0.9rem;
        color: rgba(242,234,216,0.45);
        line-height: 1.8;
        max-width: 36ch;
        margin: 0 auto 2rem;
    }

    /* Pending pulse */
    .pending-ring {
        width: 80px; height: 80px;
        border-radius: 50%;
        border: 2px solid rgba(181,118,42,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
    }
    .pending-ring::before {
        content: '';
        position: absolute;
        inset: -8px;
        border-radius: 50%;
        border: 2px solid rgba(181,118,42,0.15);
        animation: ring-pulse 2s ease-in-out infinite;
    }
    @keyframes ring-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%       { transform: scale(1.1); opacity: 0.4; }
    }

    /* Complete check */
    .complete-ring {
        width: 80px; height: 80px;
        border-radius: 50%;
        border: 2px solid rgba(101,180,101,0.4);
        background: rgba(101,180,101,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }

    .status-badge {
        display: inline-block;
        font-size: 0.7rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        margin-bottom: 1.5rem;
    }
    .badge-pending {
        background: rgba(181,118,42,0.15);
        border: 1px solid rgba(181,118,42,0.35);
        color: var(--caramel);
    }
    .badge-complete {
        background: rgba(101,180,101,0.12);
        border: 1px solid rgba(101,180,101,0.35);
        color: #8ecf8e;
    }

    .order-ref {
        font-size: 0.78rem;
        color: rgba(242,234,216,0.25);
        letter-spacing: 0.08em;
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .payment-page { padding: 2rem 1.5rem 4rem; }
    }
</style>
@endpush

@section('content')

<div class="payment-page">

    {{-- ①  Show payment form if order not yet paid --}}
    @if(isset($order) && $order->status === 'pending' && !isset($order->payment))

        <div class="page-header">
            <p class="page-eyebrow">Almost there</p>
            <h1 class="page-title">Confirm <em>Payment</em></h1>
        </div>

        {{-- Order summary --}}
        <div class="order-card">
            <p class="order-card-title">Order #{{ $order->id }}</p>
            @foreach($order->orderItems as $item)
                <div class="order-line">
                    <span class="order-line-name">{{ $item->menuItem->name }} × {{ $item->quantity }}</span>
                    <span>₱{{ number_format($item->menuItem->price * $item->quantity, 2) }}</span>
                </div>
            @endforeach
            <div class="order-divider"></div>
            <div class="order-total-row">
                <span class="order-total-label">Total to pay</span>
                <span class="order-total-amount">₱{{ number_format($total ?? 0, 2) }}</span>
            </div>
        </div>

        {{-- Pay button --}}
        <div class="pay-section">
            <form action="{{ route('payment.store', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="amount" value="{{ $total ?? 0 }}">
                <button type="submit" class="pay-btn">Pay ₱{{ number_format($total ?? 0, 2) }} &rarr;</button>
            </form>
            <p class="pay-note">Pay at the counter — this confirms your order</p>
            <a href="{{ route('orders.cart') }}" style="display:block;text-align:center;font-size:0.8rem;color:rgba(242,234,216,0.3);text-decoration:none;margin-top:0.5rem;letter-spacing:0.06em;text-transform:uppercase;transition:color 0.2s;" onmouseover="this.style.color='var(--oat)'" onmouseout="this.style.color='rgba(242,234,216,0.3)'">&larr; Back to cart</a>
        </div>


    {{-- ②  Paid — waiting for staff to mark ready --}}
    @elseif(isset($order) && in_array($order->status, ['paid', 'preparing']))

        <div class="status-card">
            <span class="status-badge badge-pending">Preparing your order</span>
            <h2 class="status-title">Hang tight!</h2>
            <p class="status-desc">Your order is being prepared by our baristas. We'll let you know the moment it's ready to serve.</p>
            <div style="background:rgba(242,234,216,0.04);border:1px solid rgba(242,234,216,0.08);border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;">
                @foreach($order->orderItems as $item)
                    <div style="display:flex;justify-content:space-between;font-size:0.85rem;color:rgba(242,234,216,0.55);margin-bottom:0.4rem;">
                        <span>{{ $item->menuItem->name }} × {{ $item->quantity }}</span>
                        <span>₱{{ number_format($item->menuItem->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
                <div style="height:1px;background:rgba(242,234,216,0.07);margin:0.75rem 0;"></div>
                <div style="display:flex;justify-content:space-between;font-family:'Cormorant Garamond',serif;font-size:1.1rem;color:var(--oat);">
                    <span>Total paid</span>
                    <span style="color:var(--caramel);">₱{{ number_format($total ?? 0, 2) }}</span>
                </div>
            </div>
            <p class="order-ref">Order #{{ $order->id }} &mdash; {{ $order->created_at->format('M d, Y · g:i A') }}</p>
        </div>


    {{-- ③  Complete --}}
    @elseif(isset($order) && $order->status === 'complete')

        <div class="status-card">
            <div class="complete-ring">✓</div>
            <span class="status-badge badge-complete">Ready to serve</span>
            <h2 class="status-title">Your order is ready!</h2>
            <p class="status-desc">Please collect your order at the counter. Thank you for choosing Brew & Bean — enjoy every sip.</p>
            <a href="{{ route('menu.index') }}" class="btn-primary" style="margin-top:0.5rem;">Order again &rarr;</a>
            <p class="order-ref">Order #{{ $order->id }} &mdash; {{ $order->created_at->format('M d, Y · g:i A') }}</p>
        </div>

    @endif

</div>

@endsection

@push('scripts')
{{-- Auto-refresh while pending so customers see status update in real time --}}
@if(isset($order) && in_array($order->status, ['paid', 'preparing']))
<script>
    setTimeout(() => location.reload(), 15000); // refresh every 15s
</script>
@endif
@endpush