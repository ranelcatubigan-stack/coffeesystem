<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order #{{ $order->id }} | Brew & Bean</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    @endif

    <style>
        :root {
            --espresso: #1c100a;
            --roast:    #3b1f10;
            --caramel:  #b5762a;
            --oat:      #f2ead8;
            --cream:    #faf7f2;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            background: var(--espresso);
            color: var(--oat);
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
            opacity: 0.04;
            pointer-events: none;
            z-index: 100;
        }

        .glow {
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(181,118,42,0.12) 0%, transparent 70%);
            top: -80px; right: -120px;
            pointer-events: none;
            animation: pulse-glow 8s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.7; transform: scale(1); }
            50%       { opacity: 1;   transform: scale(1.08); }
        }

        /* ── Nav ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 3rem;
            backdrop-filter: blur(12px);
            background: rgba(28,16,10,0.6);
            border-bottom: 1px solid rgba(242,234,216,0.07);
        }

        .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--oat);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .logo-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--caramel);
            display: inline-block;
            margin-bottom: 2px;
        }

        .nav-links { display: flex; align-items: center; gap: 1rem; }

        .btn-ghost {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.6);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
        }
        .btn-ghost:hover { color: var(--oat); }

        /* ── Page ── */
        .page {
            max-width: 780px;
            margin: 0 auto;
            padding: 8rem 3rem 5rem;
        }

        /* ── Back link ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.4);
            text-decoration: none;
            margin-bottom: 2.5rem;
            transition: color 0.2s, gap 0.2s;
            opacity: 0;
            animation: fade-up 0.5s 0.05s forwards;
        }
        .back-link:hover { color: var(--caramel); gap: 0.75rem; }

        /* ── Header ── */
        .order-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 3rem;
            gap: 1rem;
            opacity: 0;
            animation: fade-up 0.6s 0.15s forwards;
        }

        .eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .eyebrow::before {
            content: '';
            display: block;
            width: 32px; height: 1px;
            background: var(--caramel);
        }

        .order-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 300;
            line-height: 1.1;
            color: var(--oat);
        }

        .order-title em {
            font-style: italic;
            font-weight: 600;
            color: var(--caramel);
        }

        .order-date {
            font-size: 0.82rem;
            color: rgba(242,234,216,0.4);
            margin-top: 0.5rem;
        }

        .header-right { text-align: right; }

        .status-badge {
            display: inline-block;
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 0.4rem 1.1rem;
            border-radius: 999px;
            margin-bottom: 0.75rem;
        }

        .status-pending {
            background: rgba(181,118,42,0.15);
            border: 1px solid rgba(181,118,42,0.35);
            color: #d4923c;
        }

        .status-completed {
            background: rgba(74,163,96,0.12);
            border: 1px solid rgba(74,163,96,0.3);
            color: #5cb97a;
        }

        .order-grand-total {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--caramel);
            line-height: 1;
        }

        .total-label {
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.3);
            margin-top: 0.2rem;
        }

        /* ── Section ── */
        .section {
            margin-bottom: 2rem;
            opacity: 0;
            animation: fade-up 0.6s forwards;
        }

        .section-title {
            font-size: 0.7rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.3);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(242,234,216,0.07);
        }

        /* ── Items list ── */
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.4rem;
            background: rgba(242,234,216,0.03);
            border: 1px solid rgba(242,234,216,0.07);
            border-radius: 10px;
            transition: background 0.2s, border-color 0.2s;
        }
        .item-row:hover {
            background: rgba(242,234,216,0.05);
            border-color: rgba(242,234,216,0.12);
        }

        .item-left { display: flex; align-items: center; gap: 1rem; }

        .item-qty {
            width: 28px; height: 28px;
            border-radius: 6px;
            background: rgba(181,118,42,0.15);
            border: 1px solid rgba(181,118,42,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--caramel);
            flex-shrink: 0;
        }

        .item-name {
            font-size: 0.9rem;
            color: var(--oat);
        }

        .item-unit {
            font-size: 0.75rem;
            color: rgba(242,234,216,0.35);
            margin-top: 0.1rem;
        }

        .item-subtotal {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--oat);
        }

        /* ── Totals block ── */
        .totals-block {
            background: rgba(242,234,216,0.03);
            border: 1px solid rgba(242,234,216,0.08);
            border-radius: 14px;
            padding: 1.4rem 1.6rem;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.45rem 0;
            font-size: 0.85rem;
            color: rgba(242,234,216,0.5);
        }

        .total-row.grand {
            border-top: 1px solid rgba(242,234,216,0.1);
            margin-top: 0.5rem;
            padding-top: 1rem;
            color: var(--oat);
            font-size: 1rem;
        }

        .total-row.grand .amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--caramel);
        }

        /* ── Payment info ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .info-card {
            background: rgba(242,234,216,0.03);
            border: 1px solid rgba(242,234,216,0.07);
            border-radius: 10px;
            padding: 1.1rem 1.3rem;
        }

        .info-label {
            font-size: 0.68rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.3);
            margin-bottom: 0.4rem;
        }

        .info-value {
            font-size: 0.92rem;
            color: var(--oat);
        }

        .info-value.highlight { color: var(--caramel); }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            color: rgba(242,234,216,0.2);
            border-top: 1px solid rgba(242,234,216,0.06);
            margin-top: 4rem;
        }

        /* ── Animations ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            nav { padding: 1.2rem 1.5rem; }
            .page { padding: 6rem 1.5rem 3rem; }
            .order-header { flex-direction: column; }
            .header-right { text-align: left; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="glow"></div>

<nav>
    <a href="{{ url('/home') }}" class="logo">
        <span class="logo-dot"></span>
        Brew &amp; Bean
    </a>
    <div class="nav-links">
        <a href="{{ route('menu.index') }}" class="btn-ghost">Menu</a>
        <a href="{{ route('orders.cart') }}" class="btn-ghost">Cart</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-ghost">Sign out</button>
        </form>
    </div>
</nav>

<div class="page">

    <a href="{{ route('orders.index') }}" class="back-link">← Back to orders</a>

    {{-- Header --}}
    <div class="order-header">
        <div>
            <p class="eyebrow">Order receipt</p>
            <h1 class="order-title">Order <em>#{{ $order->id }}</em></h1>
            <p class="order-date">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <div class="header-right">
            <div>
                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="order-grand-total">₱{{ number_format($order->total_amount, 2) }}</div>
            <div class="total-label">Total amount</div>
        </div>
    </div>

    {{-- Items --}}
    <div class="section" style="animation-delay: 0.25s">
        <div class="section-title">Items ordered</div>
        <div class="items-list">
            @foreach ($order->orderItems as $item)
                <div class="item-row">
                    <div class="item-left">
                        <div class="item-qty">{{ $item->quantity }}</div>
                        <div>
                            <div class="item-name">{{ $item->menuItem->name }}</div>
                            <div class="item-unit">₱{{ number_format($item->unit_price, 2) }} each</div>
                        </div>
                    </div>
                    <div class="item-subtotal">₱{{ number_format($item->subtotal, 2) }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Totals --}}
    <div class="section" style="animation-delay: 0.35s">
        <div class="section-title">Summary</div>
        <div class="totals-block">
    <div class="total-row">
        <span>Subtotal</span>
        <span>₱{{ number_format($order->total_amount + $order->discount_amount, 2) }}</span>
    </div>
    @if($order->discount_amount > 0)
    <div class="total-row" style="color:#90d890;">
        <span style="display:flex;align-items:center;gap:.4rem;">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            Member discount (15%)
        </span>
        <span>− ₱{{ number_format($order->discount_amount, 2) }}</span>
    </div>
    @endif
    <div class="total-row">
        <span>Tax &amp; fees</span>
        <span>—</span>
    </div>
    <div class="total-row grand">
        <span>Total</span>
        <span class="amount">₱{{ number_format($order->total_amount, 2) }}</span>
    </div>
</div>
    </div>

    {{-- Payment info --}}
    @if($order->payment)
    <div class="section" style="animation-delay: 0.45s">
        <div class="section-title">Payment details</div>
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Method</div>
                <div class="info-value highlight">{{ ucfirst($order->payment->method) }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Payment status</div>
                <div class="info-value">{{ ucfirst($order->payment->status) }}</div>
            </div>
            @if($order->payment->paid_at)
            <div class="info-card">
                <div class="info-label">Paid at</div>
                <div class="info-value">{{ $order->payment->paid_at->format('M j, Y · g:i A') }}</div>
            </div>
            @endif
            <div class="info-card">
                <div class="info-label">Amount paid</div>
                <div class="info-value highlight">₱{{ number_format($order->payment->amount, 2) }}</div>
            </div>
        </div>
    </div>
    @endif

</div>

<footer>
    &copy; {{ date('Y') }} Brew &amp; Bean Coffee Roasters &mdash; Built with Laravel
</footer>

</body>
</html>