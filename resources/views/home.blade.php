@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<style>

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
    h1 em { font-style: italic; font-weight: 600; color: var(--caramel); }

    .hero-desc {
        font-size: 1rem;
        line-height: 1.8;
        color: rgba(242,234,216,0.55);
        max-width: 42ch;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fade-up 0.8s 0.5s forwards;
    }

    /* DISCOUNT BANNER */
    .discount-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, rgba(181,118,42,0.18), rgba(181,118,42,0.08));
        border: 1px solid rgba(181,118,42,0.4);
        border-radius: 999px;
        padding: 0.55rem 1.1rem 0.55rem 0.55rem;
        margin-bottom: 1.75rem;
        opacity: 0;
        animation: fade-up 0.8s 0.45s forwards;
    }
    .discount-pill-badge {
        background: var(--caramel);
        color: var(--espresso);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 700;
        padding: 0.2rem 0.75rem;
        border-radius: 999px;
        line-height: 1.4;
        white-space: nowrap;
    }
    .discount-pill-text {
        font-size: 0.8rem;
        color: rgba(242,234,216,0.7);
        letter-spacing: 0.02em;
    }
    .discount-pill-text strong {
        color: var(--oat);
        font-weight: 500;
    }

    .cta-row {
        display: flex;
        gap: 1rem;
        align-items: center;
        opacity: 0;
        animation: fade-up 0.8s 0.65s forwards;
    }

    /* ── Right cards ── */
    .hero-right {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        opacity: 0;
        animation: fade-left 0.9s 0.5s forwards;
    }

    /* DISCOUNT HERO CARD */
    .discount-card {
        background: linear-gradient(135deg, rgba(181,118,42,0.2) 0%, rgba(181,118,42,0.06) 100%);
        border: 1px solid rgba(181,118,42,0.35);
        border-radius: 20px;
        padding: 1.8rem 2rem;
        display: flex;
        gap: 1.5rem;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: border-color 0.25s, transform 0.2s, box-shadow 0.25s;
    }
    .discount-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(181,118,42,0.25), transparent 70%);
        pointer-events: none;
    }
    .discount-card:hover {
        border-color: rgba(181,118,42,0.6);
        transform: translateX(4px);
        box-shadow: 0 12px 40px rgba(181,118,42,0.15);
    }
    .discount-big-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--caramel);
        line-height: 1;
        flex-shrink: 0;
    }
    .discount-big-num span {
        font-size: 1.8rem;
        vertical-align: super;
    }
    .discount-card-text h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.3rem;
    }
    .discount-card-text p {
        font-size: 0.82rem;
        line-height: 1.7;
        color: rgba(242,234,216,0.5);
    }
    .discount-card-text a {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.6rem;
        font-size: 0.72rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--caramel);
        text-decoration: none;
        transition: gap 0.2s;
    }
    .discount-card-text a:hover { gap: 0.55rem; }

    .feature-card {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.09);
        border-radius: 16px;
        padding: 1.4rem 1.8rem;
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
    .card-body h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.3rem;
    }
    .card-body p {
        font-size: 0.83rem;
        line-height: 1.7;
        color: rgba(242,234,216,0.5);
    }

    /* STATS */
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

    /* HOW IT WORKS */
    .how-section {
        padding: 4rem 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .section-header {
        display: flex;
        align-items: baseline;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 300;
        white-space: nowrap;
    }
    .section-line {
        flex: 1;
        height: 1px;
        background: rgba(242,234,216,0.1);
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: rgba(242,234,216,0.08);
        border: 1px solid rgba(242,234,216,0.08);
        border-radius: 20px;
        overflow: hidden;
    }
    .step {
        background: var(--espresso);
        padding: 2rem 1.6rem;
        position: relative;
        transition: background 0.25s;
    }
    .step:hover { background: rgba(242,234,216,0.03); }
    .step-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 300;
        color: rgba(181,118,42,0.2);
        line-height: 1;
        margin-bottom: 1rem;
    }
    .step-icon { font-size: 1.5rem; margin-bottom: 0.75rem; }
    .step h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.4rem;
    }
    .step p {
        font-size: 0.8rem;
        line-height: 1.75;
        color: rgba(242,234,216,0.45);
    }
    .step-highlight {
        background: linear-gradient(135deg, rgba(181,118,42,0.12), rgba(181,118,42,0.04));
    }
    .step-highlight .step-num { color: rgba(181,118,42,0.4); }
    .step-highlight h4 { color: var(--caramel); }

    /* PROMOS */
    .promos-section {
        padding: 4rem 3rem;
        max-width: 1200px;
        margin: 0 auto;
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
        width: 100%; height: 190px;
        overflow: hidden; position: relative;
    }
    .promo-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
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
        top: 12px; left: 14px; z-index: 2;
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

    @keyframes fade-left {
        from { opacity: 0; transform: translateX(22px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 768px) {
        .hero { grid-template-columns: 1fr; padding: 6rem 1.5rem 3rem; gap: 2.5rem; }
        .hero-right { animation-name: fade-up; }
        .stats { padding: 1.5rem; gap: 2rem; flex-wrap: wrap; }
        .promo-grid { grid-template-columns: 1fr; }
        .promos-section, .how-section { padding: 2rem 1.5rem; }
        .steps-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .steps-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section>
    <div class="hero">
        <div class="hero-left">
            <p class="eyebrow">Est. 2026 &mdash; Specialty Coffee</p>
            <h1>Brewed with<br>intention, <em>served</em><br>with care.</h1>
            <p class="hero-desc">Single-origin beans, ethically sourced from sustainable farms across three continents. Every cup is a small ritual worth savoring.</p>

            {{-- 15% Discount Pill --}}
            @guest
            <div class="discount-pill">
                <span class="discount-pill-badge">15% OFF</span>
                <span class="discount-pill-text"><strong>Create a free account</strong> and save on every order</span>
            </div>
            @else
            <div class="discount-pill">
                <span class="discount-pill-badge">15% OFF</span>
                <span class="discount-pill-text">Your <strong>member discount</strong> is active on every order</span>
            </div>
            @endguest

            <div class="cta-row">
                <a href="{{ route('menu.index') }}" class="btn-primary">Start your order</a>
                @guest
                <a href="{{ route('register') }}" class="btn-outline">Join &amp; save 15%</a>
                @else
                <a href="{{ route('menu.index') }}" class="btn-outline">View menu</a>
                @endguest
            </div>
        </div>

        <div class="hero-right">

            {{-- 15% Discount Feature Card --}}
            <div class="discount-card">
                <div class="discount-big-num"><span>%</span>15</div>
                <div class="discount-card-text">
                    <h3>Member Discount — Every Order</h3>
                    <p>Registered customers automatically receive 15% off their entire order, every single time they order. No codes, no minimums.</p>
                    @guest
                    <a href="{{ route('register') }}">Create a free account →</a>
                    @else
                    <a href="{{ route('menu.index') }}">Order now and save →</a>
                    @endguest
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
                    <h3>Self-Service Ordering</h3>
                    <p>Browse, select, and checkout at your own pace — no queues, no waiting, just your order.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats">
        <div class="stat-item">
            <span class="stat-num">{{ $menuCount ?? '10+' }}</span>
            <span class="stat-label">Menu items</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">15%</span>
            <span class="stat-label">Member savings</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">3</span>
            <span class="stat-label">Bean origins</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">100%</span>
            <span class="stat-label">Organic &amp; ethical</span>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="how-section">
    <div class="section-header">
        <h2 class="section-title">How it works</h2>
        <div class="section-line"></div>
    </div>
    <div class="steps-grid">
        <div class="step">
            <div class="step-num">01</div>
            <h4>Browse the menu</h4>
            <p>Explore our full range of specialty coffees and freshly baked pastries.</p>
        </div>
        <div class="step">
            <div class="step-num">02</div>
            <h4>Add to cart</h4>
            <p>Pick your items and adjust quantities — your cart saves automatically.</p>
        </div>
        <div class="step step-highlight">
            <div class="step-num">03</div>
            <h4>Save 15% instantly</h4>
            <p>Logged-in members get 15% off applied automatically at checkout — no code needed.</p>
        </div>
        <div class="step">
            <div class="step-num">04</div>
            <h4>Enjoy your order</h4>
            <p>Pay your way — cash, GCash, or card — and we'll have it ready for you.</p>
        </div>
    </div>
</section>

{{-- Promos / Offers --}}
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
                <a href="{{ route('menu.index') }}" class="promo-link">Order now &rarr;</a>
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
                <a href="{{ route('menu.index') }}" class="promo-link">Order now &rarr;</a>
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
                <a href="{{ route('menu.index') }}" class="promo-link">Order now &rarr;</a>
            </div>
        </div>
    </div>
</section>

@endsection