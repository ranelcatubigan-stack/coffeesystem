<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Walk-in Order · Brew & Bean</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root{--espresso:#1c100a;--roast:#3b1f10;--caramel:#b5762a;--caramel2:#c98830;--oat:#f2ead8;--muted:rgba(242,234,216,.45);--faint:rgba(242,234,216,.06);--border:rgba(242,234,216,.09);--cream:#faf7f2}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{background:var(--espresso);color:var(--oat);font-family:'DM Sans',sans-serif;font-weight:300;min-height:100vh;overflow-x:hidden}
        body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");opacity:.035;pointer-events:none;z-index:999}
        .ambient{position:fixed;top:-220px;right:-150px;width:720px;height:720px;border-radius:50%;background:radial-gradient(circle,rgba(181,118,42,.15) 0%,transparent 65%);pointer-events:none;animation:breathe 9s ease-in-out infinite}
        @keyframes breathe{0%,100%{transform:scale(1);opacity:.7}50%{transform:scale(1.1);opacity:1}}

        /* NAV */
        nav{position:sticky;top:0;z-index:50;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 2.5rem;background:rgba(28,16,10,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
        .nav-logo{font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:600;color:var(--oat);text-decoration:none;display:flex;align-items:center;gap:.5rem}
        .logo-pip{width:7px;height:7px;border-radius:50%;background:var(--caramel);flex-shrink:0}
        .nav-badge{font-size:.68rem;letter-spacing:.14em;text-transform:uppercase;color:var(--caramel);background:rgba(181,118,42,.1);border:1px solid rgba(181,118,42,.25);padding:.28rem .85rem;border-radius:999px}
        .nav-cart{display:flex;align-items:center;gap:.55rem;text-decoration:none;color:var(--oat);background:var(--faint);border:1px solid var(--border);padding:.5rem 1.1rem;border-radius:999px;font-size:.8rem;font-weight:400;transition:background .2s,border-color .2s}
        .nav-cart:hover{background:rgba(242,234,216,.1);border-color:rgba(242,234,216,.18)}
        .cart-bubble{background:var(--caramel);color:var(--espresso);font-size:.62rem;font-weight:700;width:18px;height:18px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center}

        /* HERO STRIP */
        .hero-strip{padding:3.5rem 2.5rem 2rem;max-width:1280px;margin:0 auto;display:flex;align-items:flex-end;justify-content:space-between;gap:2rem;flex-wrap:wrap;opacity:0;animation:slideUp .7s .05s forwards}
        .eyebrow{display:flex;align-items:center;gap:.6rem;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel);margin-bottom:.75rem}
        .eyebrow::before{content:'';display:block;width:28px;height:1px;background:var(--caramel)}
        .page-title{font-family:'Cormorant Garamond',serif;font-size:clamp(2.8rem,5vw,4.2rem);font-weight:300;line-height:1.0;color:var(--oat)}
        .page-title em{font-style:italic;color:var(--caramel);font-weight:600}
        .no-login-note{margin-top:1rem;font-size:.82rem;color:var(--muted);display:flex;align-items:center;gap:.5rem}

        /* Category tabs */
        .category-tabs{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
        .tab-btn{background:var(--faint);border:1px solid var(--border);color:var(--muted);padding:.45rem 1.1rem;border-radius:999px;font-family:'DM Sans',sans-serif;font-size:.78rem;font-weight:400;cursor:pointer;transition:all .2s;white-space:nowrap}
        .tab-btn:hover,.tab-btn.active{background:rgba(181,118,42,.12);border-color:rgba(181,118,42,.35);color:var(--caramel)}

        /* MENU BODY */
        .menu-body{max-width:1280px;margin:0 auto;padding:0 2.5rem 9rem}
        .flash{margin-bottom:1.5rem;padding:.8rem 1.2rem;border-radius:10px;font-size:.84rem;background:rgba(100,200,100,.08);border:1px solid rgba(100,200,100,.2);color:#90d890;display:flex;align-items:center;gap:.5rem}

        /* Category section */
        .cat-section{margin-bottom:3.5rem;opacity:0}
        .cat-section:nth-child(1){animation:slideUp .6s .1s forwards}
        .cat-section:nth-child(2){animation:slideUp .6s .18s forwards}
        .cat-section:nth-child(3){animation:slideUp .6s .26s forwards}
        .cat-section:nth-child(4){animation:slideUp .6s .34s forwards}
        .cat-section:nth-child(5){animation:slideUp .6s .42s forwards}
        .cat-header{display:flex;align-items:center;gap:1.2rem;margin-bottom:1.4rem}
        .cat-name{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:300;font-style:italic;color:rgba(242,234,216,.5);white-space:nowrap}
        .cat-rule{flex:1;height:1px;background:var(--border)}
        .cat-count{font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(242,234,216,.2)}

        /* Menu grid — card layout */
        .menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.25rem}

        /* Item card */
        .menu-card{background:rgba(250,247,242,.06);border:1px solid rgba(242,234,216,.1);border-radius:20px;overflow:hidden;transition:transform .3s,box-shadow .3s,border-color .3s;display:flex;flex-direction:column}
        .menu-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(0,0,0,.4);border-color:rgba(181,118,42,.3)}

        /* Card image */
        .card-img-wrap{position:relative;width:100%;aspect-ratio:4/3;overflow:hidden;background:rgba(242,234,216,.04)}
        .card-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease;filter:brightness(.88) saturate(.9)}
        .menu-card:hover .card-img-wrap img{transform:scale(1.07);filter:brightness(.95) saturate(1)}
        .card-img-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:linear-gradient(135deg,rgba(59,31,16,.6),rgba(28,16,10,.8))}
        .card-category-badge{position:absolute;top:12px;left:12px;font-size:.62rem;letter-spacing:.12em;text-transform:uppercase;color:var(--oat);background:rgba(28,16,10,.65);backdrop-filter:blur(6px);border:1px solid rgba(181,118,42,.35);border-radius:999px;padding:.22rem .7rem;z-index:2}

        /* Card body */
        .card-body{padding:1.1rem 1.2rem 1.3rem;display:flex;flex-direction:column;flex:1;gap:.5rem}
        .card-name{font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--oat);line-height:1.2}
        .card-desc{font-size:.78rem;color:rgba(242,234,216,.4);line-height:1.65;flex:1}
        .card-footer{display:flex;flex-direction:column;margin-top:.75rem;gap:.65rem}
        .card-price-row{display:flex;align-items:center;justify-content:space-between}
        .card-price{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--caramel);line-height:1}
        .card-order-row{display:flex;align-items:center;gap:.5rem}

        /* Qty stepper */
        .qty-stepper{display:flex;align-items:center;gap:.3rem;background:rgba(242,234,216,.06);border:1px solid rgba(242,234,216,.14);border-radius:999px;padding:.2rem .4rem}
        .qty-btn{width:24px;height:24px;border-radius:50%;border:none;background:transparent;color:var(--oat);font-size:1rem;line-height:1;cursor:pointer;transition:background .15s;display:flex;align-items:center;justify-content:center}
        .qty-btn:hover{background:rgba(181,118,42,.25)}
        .qty-num{font-size:.85rem;min-width:20px;text-align:center;color:var(--oat);user-select:none}

        /* Add button */
        .btn-add{display:inline-flex;align-items:center;gap:.4rem;background:var(--caramel);color:var(--espresso);border:none;padding:.6rem 1.1rem;border-radius:999px;font-family:'DM Sans',sans-serif;font-size:.75rem;font-weight:500;letter-spacing:.03em;cursor:pointer;transition:background .2s,transform .15s,box-shadow .2s;text-decoration:none;white-space:nowrap;flex:1;justify-content:center}
        .btn-add:hover{background:var(--caramel2);transform:translateY(-1px);box-shadow:0 6px 20px rgba(181,118,42,.35)}

        /* FLOATING CART */
        .float-cart{position:fixed;bottom:2rem;left:50%;transform:translateX(-50%) translateY(120px);z-index:40;opacity:0;transition:transform .45s cubic-bezier(.34,1.56,.64,1),opacity .3s;pointer-events:none}
        .float-cart.show{transform:translateX(-50%) translateY(0);opacity:1;pointer-events:auto}
        .float-cart-inner{display:flex;align-items:center;gap:1.2rem;background:var(--oat);color:var(--espresso);padding:.9rem 1.8rem;border-radius:999px;text-decoration:none;font-weight:500;font-size:.88rem;box-shadow:0 12px 40px rgba(0,0,0,.55),0 0 0 1px rgba(181,118,42,.25);transition:transform .2s}
        .float-cart-inner:hover{transform:scale(1.02)}
        .float-cart-items{display:flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--roast)}
        .float-count{background:var(--caramel);color:#fff;font-size:.62rem;font-weight:700;width:20px;height:20px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center}
        .float-div{width:1px;height:18px;background:rgba(59,31,16,.2)}
        .float-cta{font-size:.82rem;font-weight:600;color:var(--roast)}

        .empty-state{text-align:center;padding:5rem 2rem;color:rgba(242,234,216,.25)}
        .empty-state .icon{font-size:3rem;margin-bottom:1rem;display:block}

        @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){nav{padding:1rem 1.25rem}.hero-strip{padding:2rem 1.25rem 1.5rem;flex-direction:column;align-items:flex-start}.menu-body{padding:0 1.25rem 9rem}.menu-grid{grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.85rem}}
        @media(max-width:480px){.menu-grid{grid-template-columns:1fr}.page-title{font-size:2.4rem}}
    </style>
</head>
<body>
<div class="ambient"></div>

<nav>
    <a href="{{ url('/') }}" class="nav-logo"><span class="logo-pip"></span>Brew &amp; Bean</a>
    <span class="nav-badge">Walk-in</span>
    @php $cartCount = $cart ? $cart->orderItems()->count() : 0; @endphp
    <a href="{{ route('walkin.cart') }}" class="nav-cart">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        Cart
        @if($cartCount > 0)<span class="cart-bubble">{{ $cartCount }}</span>@endif
    </a>
</nav>

<div class="hero-strip">
    <div>
        <p class="eyebrow">Walk-in Order</p>
        <h1 class="page-title">What would you<br>like to <em>order?</em></h1>
        <p class="no-login-note">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            No account needed — just pick items and enter your name at checkout.
        </p>
    </div>
    <div class="category-tabs">
        <button class="tab-btn active" onclick="scrollCat('all',this)">All</button>
        @foreach($menuItems as $cat => $items)
            <button class="tab-btn" onclick="scrollCat('{{ Str::slug($cat) }}',this)">{{ $cat }}</button>
        @endforeach
    </div>
</div>

<div class="menu-body">
    @if(session('success'))
        <div class="flash">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @forelse($menuItems as $category => $items)
        <div class="cat-section" id="cat-{{ Str::slug($category) }}">
            <div class="cat-header">
                <h2 class="cat-name">{{ $category }}</h2>
                <div class="cat-rule"></div>
                <span class="cat-count">{{ $items->count() }} items</span>
            </div>
            <div class="menu-grid">
                @foreach($items as $index => $item)
                    <div class="menu-card" style="animation-delay:{{ $index * 0.06 }}s">

                        {{-- Image --}}
                        <div class="card-img-wrap">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <div class="card-img-placeholder">☕</div>
                            @endif
                            <span class="card-category-badge">{{ $category }}</span>
                        </div>

                        {{-- Body --}}
                        <div class="card-body">
                            <div class="card-name">{{ $item->name }}</div>
                            @if($item->description)
                                <div class="card-desc">{{ Str::limit($item->description, 80) }}</div>
                            @endif

                            <div class="card-footer">
                                <div class="card-price-row">
                                    <span class="card-price">₱{{ number_format($item->price, 2) }}</span>
                                </div>
                                <form action="{{ route('walkin.store') }}" method="POST" style="display:contents">
                                    @csrf
                                    <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                    <div class="card-order-row">
                                        <div class="qty-stepper">
                                            <button type="button" class="qty-btn" onclick="adj(this,-1)">−</button>
                                            <span class="qty-num" id="qdisplay-{{ $item->id }}">1</span>
                                            <input type="hidden" name="quantity" id="qval-{{ $item->id }}" value="1">
                                            <button type="button" class="qty-btn" onclick="adj(this,1)">+</button>
                                        </div>
                                        <button type="submit" class="btn-add">Add →</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state"><span class="icon">☕</span><p>No menu items available.</p></div>
    @endforelse
</div>

<a href="{{ route('walkin.cart') }}" class="float-cart {{ $cartCount > 0 ? 'show' : '' }}" id="floatCart">
    <div class="float-cart-inner">
        <div class="float-cart-items">
            <span class="float-count" id="fcCount">{{ $cartCount }}</span>
            item{{ $cartCount !== 1 ? 's' : '' }} in cart
        </div>
        <div class="float-div"></div>
        <span class="float-cta">View Cart →</span>
    </div>
</a>

<script>
function scrollCat(slug, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    if (slug === 'all') { window.scrollTo({ top: 0, behavior: 'smooth' }); return; }
    const el = document.getElementById('cat-' + slug);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function adj(btn, dir) {
    // Find the hidden input and display span inside this card
    const card = btn.closest('.menu-card');
    const input = card.querySelector('input[name="quantity"]');
    const display = card.querySelector('.qty-num');
    let val = Math.max(1, Math.min(99, parseInt(input.value || 1) + dir));
    input.value = val;
    display.textContent = val;
}
</script>
</body>
</html>