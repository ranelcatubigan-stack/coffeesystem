<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brew & Bean | Coffee Shop</title>

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
        }
        .btn-ghost:hover { color: var(--oat); }

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

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            padding: 8rem 3rem 4rem;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-left { position: relative; }

        .eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            opacity: 0;
            animation: fade-up 0.8s 0.2s forwards;
        }
        .eyebrow::before {
            content: '';
            display: block;
            width: 32px; height: 1px;
            background: var(--caramel);
        }

        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3.5rem, 6vw, 6rem);
            font-weight: 300;
            line-height: 1.05;
            color: var(--oat);
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fade-up 0.8s 0.35s forwards;
        }

        h1 em {
            font-style: italic;
            font-weight: 600;
            color: var(--caramel);
        }

        .hero-desc {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.8;
            color: rgba(242,234,216,0.55);
            max-width: 42ch;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fade-up 0.8s 0.5s forwards;
        }

        .cta-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fade-up 0.8s 0.65s forwards;
        }

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
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
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
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-outline:hover {
            border-color: rgba(242,234,216,0.5);
            background: rgba(242,234,216,0.05);
        }

        /* ── Right side cards ── */
        .hero-right {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            opacity: 0;
            animation: fade-left 0.9s 0.5s forwards;
        }

        .feature-card {
            background: rgba(242,234,216,0.04);
            border: 1px solid rgba(242,234,216,0.09);
            border-radius: 16px;
            padding: 1.6rem 1.8rem;
            display: flex;
            gap: 1.2rem;
            align-items: flex-start;
            transition: background 0.25s, border-color 0.25s, transform 0.2s;
        }
        .feature-card:hover {
            background: rgba(242,234,216,0.07);
            border-color: rgba(181,118,42,0.25);
            transform: translateX(4px);
        }

        /* Special highlight card for discount */
        .feature-card.discount-card {
            background: rgba(181,118,42,0.1);
            border: 1px solid rgba(181,118,42,0.35);
            position: relative;
            overflow: hidden;
        }
        .feature-card.discount-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(181,118,42,0.15), transparent 60%);
            pointer-events: none;
        }
        .feature-card.discount-card:hover {
            background: rgba(181,118,42,0.15);
            border-color: rgba(181,118,42,0.55);
        }

        .card-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(181,118,42,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .discount-card .card-icon {
            background: rgba(181,118,42,0.25);
        }

        .card-body h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--oat);
            margin-bottom: 0.35rem;
        }

        .card-body p {
            font-size: 0.85rem;
            line-height: 1.7;
            color: rgba(242,234,216,0.5);
        }

        .discount-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.6rem;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--caramel);
            background: rgba(181,118,42,0.15);
            border: 1px solid rgba(181,118,42,0.3);
            border-radius: 999px;
            padding: 0.25rem 0.8rem;
        }

        /* ── Discount section ── */
        .discount-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem 4rem;
            opacity: 0;
            animation: fade-up 0.8s 0.8s forwards;
        }

        .discount-banner {
            background: linear-gradient(135deg, rgba(181,118,42,0.12), rgba(181,118,42,0.06));
            border: 1px solid rgba(181,118,42,0.3);
            border-radius: 20px;
            padding: 2.5rem 3rem;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        .discount-banner::before {
            content: '15%';
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'Cormorant Garamond', serif;
            font-size: 8rem;
            font-weight: 600;
            color: rgba(181,118,42,0.08);
            line-height: 1;
            pointer-events: none;
        }

        .discount-banner-label {
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .discount-banner-label::before {
            content: '';
            display: block;
            width: 24px; height: 1px;
            background: var(--caramel);
        }

        .discount-banner h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 300;
            color: var(--oat);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .discount-banner h2 em {
            font-style: italic;
            font-weight: 600;
            color: var(--caramel);
        }

        .discount-banner p {
            font-size: 0.88rem;
            color: rgba(242,234,216,0.5);
            line-height: 1.75;
            max-width: 50ch;
        }

        .discount-steps {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }

        .discount-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: rgba(242,234,216,0.55);
        }

        .step-num {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: rgba(181,118,42,0.2);
            border: 1px solid rgba(181,118,42,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--caramel);
            flex-shrink: 0;
        }

        .discount-cta {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            z-index: 1;
        }

        .discount-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.5rem;
            font-weight: 600;
            color: var(--caramel);
            line-height: 1;
            text-align: center;
        }

        .discount-amount span {
            font-size: 1.2rem;
            color: rgba(242,234,216,0.5);
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 0.2rem;
        }

        /* ── Stats strip ── */
        .stats {
            border-top: 1px solid rgba(242,234,216,0.08);
            padding: 2rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 3rem;
            opacity: 0;
            animation: fade-up 0.8s 0.9s forwards;
        }

        .stat-item { display: flex; flex-direction: column; gap: 0.2rem; }

        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--caramel);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(242,234,216,0.4);
        }

        /* ── Promos section ── */
        .promos-section {
            padding: 4rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            align-items: baseline;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 300;
        }

        .section-line {
            flex: 1;
            height: 1px;
            background: rgba(242,234,216,0.1);
        }

        .promo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .promo-card {
            background: rgba(242,234,216,0.03);
            border: 1px solid rgba(242,234,216,0.08);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.25s, box-shadow 0.3s;
            cursor: pointer;
        }
        .promo-card:hover {
            border-color: rgba(181,118,42,0.4);
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.35);
        }

        .promo-img-wrap {
            width: 100%;
            height: 190px;
            overflow: hidden;
            position: relative;
        }
        .promo-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
            filter: brightness(0.82) saturate(0.9);
        }
        .promo-card:hover .promo-img-wrap img {
            transform: scale(1.06);
            filter: brightness(0.9) saturate(1);
        }

        .promo-img-wrap::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 60px;
            background: linear-gradient(to bottom, transparent, rgba(28,16,10,0.85));
        }

        .promo-badge {
            position: absolute;
            top: 12px; left: 14px;
            z-index: 2;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--oat);
            background: rgba(28,16,10,0.65);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(181,118,42,0.45);
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
        }

        .promo-body { padding: 1.1rem 1.4rem 1.4rem; }

        .promo-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--oat);
            margin-bottom: 0.4rem;
        }

        .promo-desc {
            font-size: 0.82rem;
            color: rgba(242,234,216,0.45);
            line-height: 1.75;
        }

        .promo-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.9rem;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--caramel);
            text-decoration: none;
            transition: gap 0.2s;
        }
        .promo-link:hover { gap: 0.6rem; }

        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            color: rgba(242,234,216,0.2);
            border-top: 1px solid rgba(242,234,216,0.06);
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-left {
            from { opacity: 0; transform: translateX(22px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 768px) {
            nav { padding: 1.2rem 1.5rem; }
            .hero { grid-template-columns: 1fr; padding: 6rem 1.5rem 3rem; gap: 2.5rem; }
            .hero-right { animation-name: fade-up; }
            .stats { padding: 1.5rem; gap: 2rem; flex-wrap: wrap; }
            .promo-grid { grid-template-columns: 1fr; }
            .promos-section { padding: 2rem 1.5rem; }
            .discount-banner { grid-template-columns: 1fr; padding: 2rem 1.5rem; }
            .discount-banner::before { display: none; }
            .discount-section { padding: 0 1.5rem 3rem; }
        }
    </style>
</head>
<body>

<div class="glow"></div>

{{-- Navigation --}}
<nav>
    <div class="logo">
        <span class="logo-dot"></span>
        Brew &amp; Bean
    </div>
    @if (Route::has('login'))
        <div class="nav-links">
            <a href="{{ route('walkin.menu') }}" class="btn-ghost">Walk-in Order</a>
            @auth
                <a href="{{ url('/home') }}" class="btn-pill">Home</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Sign in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-pill">Get started</a>
                @endif
            @endauth
        </div>
    @endif
</nav>

{{-- Hero --}}
<section>
    <div class="hero">
        <div class="hero-left">
            <p class="eyebrow">Est. 2026 &mdash; Specialty Coffee</p>
            <h1>Brewed with<br>intention, <em>served</em><br>with care.</h1>
            <p class="hero-desc">Single-origin beans, ethically sourced from sustainable farms across three continents. Every cup is a small ritual worth savoring.</p>
            <div class="cta-row">
                @auth
                    <a href="{{ url('/home') }}" class="btn-primary"> Start your order</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary"> Join & Save 15%</a>
                    <a href="{{ route('walkin.menu') }}" class="btn-outline">Walk-in Order</a>
                @endauth
            </div>
        </div>

        <div class="hero-right">
            {{-- Discount highlight card --}}
            <div class="feature-card discount-card">
                <div class="card-body">
                    <h3>Member Discount</h3>
                    <p>Sign up for a free account and enjoy <strong style="color:var(--caramel);">15% off every order</strong>, automatically applied at checkout.</p>
                    <span class="discount-badge">✦ 15% off all orders</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="card-body">
                    <h3>Seasonal Blends</h3>
                    <p>Our limited-time autumn roast carries warm notes of nutmeg, dark maple, and toasted hazelnut.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="card-body">
                    <h3>Self-Service Kiosk</h3>
                    <p>Browse, select, and checkout at your own pace — no queues, no waiting, just your order.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats">
        <div class="stat-item">
            <span class="stat-num">15%</span>
            <span class="stat-label">Member discount</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">3</span>
            <span class="stat-label">Bean origins</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">100%</span>
            <span class="stat-label">Organic &amp; ethical</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">Daily</span>
            <span class="stat-label">Fresh pastries</span>
        </div>
    </div>
</section>

{{-- 15% Discount Banner --}}
@guest
<div class="discount-section">
    <div class="discount-banner">
        <div>
            <p class="discount-banner-label">Member exclusive</p>
            <h2>Save <em>15%</em> on every<br>single order you place</h2>
            <p>Create a free Brew & Bean account and your discount is applied automatically at checkout — no codes, no hassle, every time.</p>
            <div class="discount-steps">
                <div class="discount-step">
                    <span class="step-num">1</span>
                    <span>Create a free account</span>
                </div>
                <div class="discount-step">
                    <span class="step-num">2</span>
                    <span>Browse & add items</span>
                </div>
                <div class="discount-step">
                    <span class="step-num">3</span>
                    <span>15% off at checkout</span>
                </div>
            </div>
        </div>
        <div class="discount-cta">
            <div class="discount-amount">
                15%
                <span>off every order</span>
            </div>
            <a href="{{ route('register') }}" class="btn-primary" style="white-space:nowrap;">
                 &nbsp;Create Account
            </a>
            <a href="{{ route('login') }}" class="btn-ghost" style="font-size:0.75rem;">
                Already a member? Sign in
            </a>
        </div>
    </div>
</div>
@endguest

{{-- Promos --}}
<section class="promos-section">
    <div class="section-header">
        <h2 class="section-title">Today's offers</h2>
        <div class="section-line"></div>
    </div>
    <div class="promo-grid">
        <div class="promo-card">
            <div class="promo-img-wrap">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600&q=80" alt="Espresso and croissant" loading="lazy">
                <span class="promo-badge">Limited time</span>
            </div>
            <div class="promo-body">
                <p class="promo-title">Morning Duo</p>
                <p class="promo-desc">Any espresso drink paired with a freshly baked croissant — available before 10 AM.</p>
                <a href="{{ route('walkin.menu') }}" class="promo-link">Order now &rarr;</a>
            </div>
        </div>

        <div class="promo-card">
            <div class="promo-img-wrap">
                <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=600&q=80" alt="Cold brew coffee" loading="lazy">
                <span class="promo-badge">Weekend special</span>
            </div>
            <div class="promo-body">
                <p class="promo-title">Cold Brew Bundle</p>
                <p class="promo-desc">Get two cold brews at the price of one, every Saturday and Sunday.</p>
                <a href="{{ route('walkin.menu') }}" class="promo-link">Order now &rarr;</a>
            </div>
        </div>

        <div class="promo-card">
            <div class="promo-img-wrap">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&q=80" alt="Autumn roast coffee" loading="lazy">
                <span class="promo-badge">New arrival</span>
            </div>
            <div class="promo-body">
                <p class="promo-title">Autumn Roast</p>
                <p class="promo-desc">Our seasonal single-origin from Ethiopia — notes of fig, cardamom, and brown sugar.</p>
                <a href="{{ route('walkin.menu') }}" class="promo-link">Order now &rarr;</a>
            </div>
        </div>
    </div>
</section>

<footer>
    &copy; {{ date('Y') }} Brew &amp; Bean Coffee Roasters &mdash; Built with Laravel
</footer>

</body>
</html>