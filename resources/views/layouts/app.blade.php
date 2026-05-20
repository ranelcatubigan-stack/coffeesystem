<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brew & Bean | @yield('title', 'Coffee Shop')</title>

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
            --espresso:   #1c100a;
            --roast:      #3b1f10;
            --caramel:    #b5762a;
            --oat:        #f2ead8;
            --cream:      #faf7f2;
            --steam:      rgba(242,234,216,0.06);
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
            width: 680px; height: 680px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(181,118,42,0.18) 0%, transparent 70%);
            top: -120px; right: -180px;
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
            letter-spacing: 0.02em;
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
            font-weight: 400;
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
        }
        .btn-ghost:hover { color: var(--oat); }
        .btn-ghost.active { color: var(--caramel); }

        .btn-pill {
            font-size: 0.8rem;
            font-weight: 400;
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

        .cart-btn {
            font-size: 0.8rem;
            font-weight: 400;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.6);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .cart-btn:hover { color: var(--oat); }
        .cart-btn.active { color: var(--caramel); }

        .cart-count {
            background: var(--caramel);
            color: var(--espresso);
            font-size: 0.65rem;
            font-weight: 500;
            border-radius: 999px;
            padding: 0.1rem 0.45rem;
            min-width: 18px;
            text-align: center;
        }

        /* ── Main content ── */
        .page-wrapper {
            padding-top: 80px;
            min-height: 100vh;
        }

        /* ── Shared buttons ── */
        .btn-primary {
            background: var(--caramel);
            color: var(--espresso);
            border: none;
            padding: 0.9rem 2.2rem;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary:hover {
            background: #c98830;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(181,118,42,0.35);
        }

        .btn-outline {
            background: transparent;
            color: var(--oat);
            border: 1px solid rgba(242,234,216,0.2);
            padding: 0.9rem 2.2rem;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 400;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline:hover {
            border-color: rgba(242,234,216,0.5);
            background: rgba(242,234,216,0.05);
        }

        .btn-danger {
            background: transparent;
            color: #e07070;
            border: 1px solid rgba(224,112,112,0.3);
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-danger:hover {
            background: rgba(224,112,112,0.1);
            border-color: rgba(224,112,112,0.6);
        }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            color: rgba(242,234,216,0.2);
            border-top: 1px solid rgba(242,234,216,0.06);
        }

        /* ── Animations ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* ── Alerts ── */
        .alert {
            padding: 0.85rem 1.4rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            animation: fade-up 0.4s forwards;
        }
        .alert-success {
            background: rgba(101,180,101,0.1);
            border: 1px solid rgba(101,180,101,0.3);
            color: #8ecf8e;
        }
        .alert-error {
            background: rgba(224,112,112,0.1);
            border: 1px solid rgba(224,112,112,0.3);
            color: #e07070;
        }

        @media (max-width: 768px) {
            nav { padding: 1.2rem 1.5rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="glow"></div>

<nav>
    {{-- Logo --}}
    @auth
        <a href="{{ auth()->user()->role === 'staff' ? route('staff.dashboard') : route('home') }}" class="logo">
            <span class="logo-dot"></span>
            Brew &amp; Bean
        </a>
    @else
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-dot"></span>
            Brew &amp; Bean
        </a>
    @endauth

    {{-- Nav links --}}
    <div class="nav-links">

        @auth
            @if(auth()->user()->role === 'staff')
                {{-- ── Staff nav ── --}}
                <a href="{{ route('staff.dashboard') }}"
                   class="btn-ghost {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                   Dashboard
                </a>
                <a href="{{ route('staff.menu.create') }}"
                   class="btn-ghost {{ request()->routeIs('staff.menu.create') ? 'active' : '' }}">
                   Add Item
                </a>

            @else
                {{-- ── Customer nav ── --}}
                <a href="{{ route('menu.index') }}"
                   class="btn-ghost {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                   Menu
                </a>
                <a href="{{ route('orders.index') }}"
                   class="btn-ghost {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                   My Orders
                </a>
                <a href="{{ route('orders.cart') }}"
                   class="cart-btn {{ request()->routeIs('orders.cart') ? 'active' : '' }}">
                    Cart
                    @php $cartCount = count(session()->get('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>

            @endif

            {{-- Sign out — shown for both staff and customer --}}
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-ghost">Sign out</button>
            </form>

        @else
            {{-- ── Guest nav ── --}}
            <a href="{{ route('login') }}" class="btn-ghost">Sign in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-pill">Get started</a>
            @endif

        @endauth

    </div>
</nav>

<div class="page-wrapper">
    @yield('content')
</div>

<footer>
    &copy; {{ date('Y') }} Brew &amp; Bean Coffee Roasters &mdash; Built with Laravel
</footer>

@stack('scripts')
</body>
</html>