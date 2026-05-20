<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu | Brew & Bean</title>

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
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(181,118,42,0.13) 0%, transparent 70%);
            top: -200px; right: -200px;
            pointer-events: none;
            animation: pulse-glow 9s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50%       { opacity: 1;   transform: scale(1.1); }
        }

        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 3rem;
            backdrop-filter: blur(12px);
            background: rgba(28,16,10,0.65);
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
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-pill:hover { background: #c98830; transform: translateY(-1px); }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 8rem 3rem 5rem;
        }

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
        }
        .page-title em { font-style: italic; font-weight: 600; color: var(--caramel); }

        .filter-bar {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fade-up 0.7s 0.2s forwards;
        }

        .filter-tab {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.45rem 1.1rem;
            border-radius: 999px;
            border: 1px solid rgba(242,234,216,0.15);
            background: rgba(242,234,216,0.04);
            color: rgba(242,234,216,0.5);
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-tab:hover,
        .filter-tab.active {
            background: rgba(181,118,42,0.18);
            border-color: rgba(181,118,42,0.4);
            color: var(--caramel);
        }

        .category-heading {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 300;
            color: rgba(242,234,216,0.5);
            margin-bottom: 1.25rem;
            margin-top: 2.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .category-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(242,234,216,0.08);
        }
        .category-heading:first-of-type { margin-top: 0; }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .menu-card {
            background: rgba(250,247,242,0.06);
            border: 1px solid rgba(242,234,216,0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
            opacity: 0;
            animation: fade-up 0.5s forwards;
            display: flex;
            flex-direction: column;
        }
        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            border-color: rgba(181,118,42,0.3);
        }

        .card-img-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: rgba(242,234,216,0.04);
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            filter: brightness(0.88) saturate(0.9);
        }
        .menu-card:hover .card-img-wrap img {
            transform: scale(1.07);
            filter: brightness(0.95) saturate(1);
        }

        .card-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            background: linear-gradient(135deg, rgba(59,31,16,0.6), rgba(28,16,10,0.8));
        }

        .card-category {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 0.62rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--oat);
            background: rgba(28,16,10,0.65);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(181,118,42,0.35);
            border-radius: 999px;
            padding: 0.22rem 0.7rem;
            z-index: 2;
        }

        .unavailable-overlay {
            position: absolute;
            inset: 0;
            background: rgba(28,16,10,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }
        .unavailable-label {
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.6);
            border: 1px solid rgba(242,234,216,0.25);
            border-radius: 999px;
            padding: 0.35rem 1rem;
            backdrop-filter: blur(4px);
        }

        .card-body {
            padding: 1.1rem 1.2rem 1.3rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 0.5rem;
        }

        .card-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--oat);
            line-height: 1.2;
        }

        .card-desc {
            font-size: 0.78rem;
            color: rgba(242,234,216,0.4);
            line-height: 1.65;
            flex: 1;
        }

        .card-footer {
            display: flex;
            flex-direction: column;
            margin-top: 0.75rem;
            gap: 0.65rem;
        }

        .card-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-order-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-stepper {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(242,234,216,0.06);
            border: 1px solid rgba(242,234,216,0.14);
            border-radius: 999px;
            padding: 0.2rem 0.4rem;
        }

        .qty-btn {
            width: 24px; height: 24px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: var(--oat);
            font-size: 1rem;
            line-height: 1;
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qty-btn:hover { background: rgba(181,118,42,0.25); }

        .qty-num {
            font-size: 0.85rem;
            min-width: 20px;
            text-align: center;
            color: var(--oat);
            user-select: none;
        }

        .card-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--caramel);
            line-height: 1;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--caramel);
            color: var(--espresso);
            border: none;
            padding: 0.6rem 1.1rem;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-add:hover {
            background: #c98830;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(181,118,42,0.35);
        }
        .btn-add:disabled,
        .btn-add.disabled {
            background: rgba(242,234,216,0.1);
            color: rgba(242,234,216,0.3);
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .flash {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: rgba(59,31,16,0.95);
            border: 1px solid rgba(181,118,42,0.4);
            color: var(--oat);
            padding: 0.8rem 1.6rem;
            border-radius: 999px;
            font-size: 0.82rem;
            backdrop-filter: blur(10px);
            z-index: 200;
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
        }
        .flash.show { transform: translateX(-50%) translateY(0); }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: rgba(242,234,216,0.3);
        }
        .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state p { font-size: 0.9rem; }

        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            color: rgba(242,234,216,0.2);
            border-top: 1px solid rgba(242,234,216,0.06);
            margin-top: 4rem;
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            nav { padding: 1.2rem 1.5rem; }
            .page { padding: 6rem 1.25rem 4rem; }
            .menu-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 0.85rem; }
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
        @auth
            <a href="{{ route('menu.index') }}" class="btn-pill">Menu</a>
            <a href="{{ route('orders.index') }}" class="btn-ghost">My Orders</a>
            <a href="{{ route('orders.cart') }}" class="btn-ghost">Cart</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-ghost">Sign out</button>
            </form>
        @endauth
    </div>
</nav>

<div class="page">

    @if(session('success'))
        <div class="flash show" id="flash-msg">✓ &nbsp;{{ session('success') }}</div>
        <script>setTimeout(() => document.getElementById('flash-msg')?.classList.remove('show'), 3000)</script>
    @endif

    <div class="page-header">
        <p class="eyebrow">Brew &amp; Bean</p>
        <h1 class="page-title">Our <em>Menu</em></h1>
    </div>

    @php $allCategories = $menuItems->keys(); @endphp
    <div class="filter-bar">
        <button class="filter-tab active" onclick="filterCategory('all', this)">All</button>
        @foreach($allCategories as $cat)
            <button class="filter-tab" onclick="filterCategory('{{ Str::slug($cat) }}', this)">{{ $cat }}</button>
        @endforeach
    </div>

    @forelse($menuItems as $category => $items)
        <div class="category-section" data-category="{{ Str::slug($category) }}">
            <h2 class="category-heading">{{ $category }}</h2>
            <div class="menu-grid">
                @foreach($items as $index => $item)
                    <div class="menu-card" style="animation-delay: {{ $index * 0.06 }}s">
                        <div class="card-img-wrap">
                            @if($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->name }}">

                            @else
                            @endif
                            <span class="card-category">{{ $category }}</span>
                            @if(!$item->is_available)
                                <div class="unavailable-overlay">
                                    <span class="unavailable-label">Unavailable</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-name">{{ $item->name }}</div>
                            @if($item->description)
                                <div class="card-desc">{{ Str::limit($item->description, 80) }}</div>
                            @endif
                            <div class="card-footer">
                                <div class="card-price-row">
                                    <span class="card-price">₱{{ number_format($item->price, 2) }}</span>
                                </div>
                                @auth
                                    @if($item->is_available)
                                        <form method="POST" action="{{ route('order-items.store') }}" style="display:contents" id="form-{{ $item->id }}">
                                            @csrf
                                            <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                            <div class="card-order-row">
                                                <div class="qty-stepper">
                                                    <button type="button" class="qty-btn"
                                                        onclick="changeQty('{{ $item->id }}', -1)">−</button>
                                                    <span class="qty-num" id="qty-display-{{ $item->id }}">1</span>
                                                    <input type="hidden" name="quantity" id="qty-{{ $item->id }}" value="1">
                                                    <button type="button" class="qty-btn"
                                                        onclick="changeQty('{{ $item->id }}', 1)">+</button>
                                                </div>
                                                <button type="submit" class="btn-add" style="flex:1">Add to Cart</button>
                                            </div>
                                        </form>
                                    @else
                                        <button class="btn-add disabled" disabled>Unavailable</button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-add">Sign in to Order</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state">

            <p>No menu items available yet.</p>
        </div>
    @endforelse

</div>

<footer>
    &copy; {{ date('Y') }} Brew &amp; Bean Coffee Roasters &mdash; Built with Laravel
</footer>

<script>
    function filterCategory(slug, btn) {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.category-section').forEach(section => {
            if (slug === 'all' || section.dataset.category === slug) {
                section.style.display = '';
            } else {
                section.style.display = 'none';
            }
        });
    }

    function changeQty(itemId, delta) {
        const input   = document.getElementById('qty-' + itemId);
        const display = document.getElementById('qty-display-' + itemId);
        let val = parseInt(input.value) + delta;
        if (val < 1)  val = 1;
        if (val > 99) val = 99;
        input.value    = val;
        display.textContent = val;
    }
</script>

</body>
</html>