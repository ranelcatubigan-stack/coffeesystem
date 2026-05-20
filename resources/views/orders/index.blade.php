<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders | Brew & Bean</title>

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
            --steam:    rgba(242,234,216,0.06);
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
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(181,118,42,0.14) 0%, transparent 70%);
            bottom: -100px; left: -150px;
            pointer-events: none;
            animation: pulse-glow 9s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50%       { opacity: 1;   transform: scale(1.1); }
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
        }
        .btn-ghost:hover { color: var(--oat); }

        .btn-pill {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--espresso);
            background: var(--caramel);
            text-decoration: none;
            padding: 0.55rem 1.4rem;
            border-radius: 999px;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-pill:hover { background: #c98830; transform: translateY(-1px); }

        /* ── Page ── */
        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 8rem 3rem 4rem;
        }

        /* ── Header ── */
        .page-header {
            margin-bottom: 3rem;
            opacity: 0;
            animation: fade-up 0.7s 0.1s forwards;
        }

        .eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 1rem;
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

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 300;
            line-height: 1.1;
            color: var(--oat);
            margin-bottom: 0.5rem;
        }

        .page-title em {
            font-style: italic;
            font-weight: 600;
            color: var(--caramel);
        }

        .page-sub {
            font-size: 0.9rem;
            color: rgba(242,234,216,0.45);
        }

        /* ── Actions bar ── */
        .actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fade-up 0.7s 0.25s forwards;
        }

        .btn-primary {
            background: var(--caramel);
            color: var(--espresso);
            border: none;
            padding: 0.75rem 1.8rem;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-primary:hover {
            background: #c98830;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(181,118,42,0.3);
        }

        .order-count {
            font-size: 0.8rem;
            color: rgba(242,234,216,0.35);
            letter-spacing: 0.05em;
        }

        /* ── Orders list ── */
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .order-card {
            background: rgba(242,234,216,0.03);
            border: 1px solid rgba(242,234,216,0.08);
            border-radius: 14px;
            padding: 1.5rem 1.8rem;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 1rem;
            transition: background 0.25s, border-color 0.25s, transform 0.2s;
            text-decoration: none;
            color: inherit;
            margin-bottom: 0.75rem;
            opacity: 0;
            animation: fade-up 0.6s forwards;
        }
        .order-card:hover {
            background: rgba(242,234,216,0.06);
            border-color: rgba(181,118,42,0.3);
            transform: translateX(4px);
        }

        .order-left { display: flex; flex-direction: column; gap: 0.5rem; }

        .order-id {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--oat);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-meta {
            font-size: 0.8rem;
            color: rgba(242,234,216,0.4);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .order-meta span { display: flex; align-items: center; gap: 0.3rem; }

        .order-items-preview {
            font-size: 0.82rem;
            color: rgba(242,234,216,0.55);
            margin-top: 0.25rem;
        }

        .order-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.6rem;
        }

        .order-total {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--caramel);
        }

        .status-badge {
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
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

        .arrow {
            font-size: 0.8rem;
            color: rgba(242,234,216,0.25);
            transition: color 0.2s, transform 0.2s;
        }
        .order-card:hover .arrow {
            color: var(--caramel);
            transform: translateX(3px);
        }

        /* ── Divider line between date groups ── */
        .date-group {
            margin-bottom: 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.7rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.25);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .date-group::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(242,234,216,0.07);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            opacity: 0;
            animation: fade-up 0.7s 0.3s forwards;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            opacity: 0.4;
        }

        .empty-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 300;
            color: var(--oat);
            margin-bottom: 0.75rem;
        }

        .empty-desc {
            font-size: 0.9rem;
            color: rgba(242,234,216,0.4);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
            gap: 0.4rem;
            opacity: 0;
            animation: fade-up 0.6s 0.5s forwards;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            font-size: 0.82rem;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .pagination-wrap a {
            background: rgba(242,234,216,0.05);
            border: 1px solid rgba(242,234,216,0.1);
            color: rgba(242,234,216,0.6);
        }
        .pagination-wrap a:hover {
            background: rgba(181,118,42,0.15);
            border-color: rgba(181,118,42,0.3);
            color: var(--caramel);
        }

        .pagination-wrap span.active {
            background: var(--caramel);
            color: var(--espresso);
            font-weight: 500;
        }

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
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            nav { padding: 1.2rem 1.5rem; }
            .page { padding: 6rem 1.5rem 3rem; }
            .order-card { grid-template-columns: 1fr; }
            .order-right { align-items: flex-start; flex-direction: row; justify-content: space-between; }
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
        <a href="{{ route('orders.index') }}" class="btn-ghost">My Orders</a>
        <a href="{{ route('orders.cart') }}" class="btn-ghost">Cart</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-ghost" style="background:none;border:none;cursor:pointer;">Sign out</button>
        </form>
    </div>
</nav>

<div class="page">

    <div class="page-header">
        <p class="eyebrow">Your account</p>
        <h1 class="page-title">Order <em>history</em></h1>
        <p class="page-sub">Every cup you've enjoyed with us.</p>
    </div>

    <div class="actions-bar">
        <a href="{{ route('orders.create') }}" class="btn-primary">
            ＋ &nbsp;New order
        </a>
        <span class="order-count">{{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }} total</span>
    </div>

    @if ($orders->isEmpty())
        <div class="empty-state">
            <h2 class="empty-title">No orders yet</h2>
            <p class="empty-desc">You haven't placed any orders yet.<br>Browse the menu and start your first order.</p>
            <a href="{{ route('orders.create') }}" class="btn-primary">Browse the menu</a>
        </div>
    @else
        <div class="orders-list">
            @foreach ($orders as $index => $order)
                <a href="{{ route('orders.show', $order) }}" class="order-card"
                   style="animation-delay: {{ 0.3 + $index * 0.07 }}s">
                    <div class="order-left">
                        <div class="order-id">
                            Order #{{ $order->id }}
                        </div>
                        <div class="order-meta">
                            <span>🕐 {{ $order->created_at->format('M d, Y · g:i A') }}</span>
                            <span>· {{ $order->orderItems->count() }} item{{ $order->orderItems->count() !== 1 ? 's' : '' }}</span>
                        </div>
                        @if($order->orderItems->count())
                            <div class="order-items-preview">
                                {{ $order->orderItems->take(3)->map(fn($i) => $i->menuItem->name)->join(', ') }}{{ $order->orderItems->count() > 3 ? ' +' . ($order->orderItems->count() - 3) . ' more' : '' }}
                            </div>
                        @endif
                    </div>
                    <div class="order-right">
                        <span class="order-total">₱{{ number_format($order->total_amount, 2) }}</span>
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        <span class="arrow">→</span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="pagination-wrap">
                {{-- Previous --}}
                @if($orders->onFirstPage())
                    <span style="opacity:0.3">←</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}">←</a>
                @endif

                {{-- Pages --}}
                @foreach(range(1, $orders->lastPage()) as $page)
                    @if($page == $orders->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $orders->url($page) }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}">→</a>
                @else
                    <span style="opacity:0.3">→</span>
                @endif
            </div>
        @endif
    @endif

</div>

<footer>
    &copy; {{ date('Y') }} Brew &amp; Bean Coffee Roasters &mdash; Built with Laravel
</footer>

</body>
</html>