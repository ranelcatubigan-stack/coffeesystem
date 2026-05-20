<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Placed · Brew & Bean</title>
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

        /* PAGE WRAP */
        .page-wrap{max-width:980px;margin:0 auto;padding:4rem 2.5rem 8rem;display:grid;grid-template-columns:1fr 360px;gap:3rem;align-items:start}

        /* LEFT */
        .success-side{opacity:0;animation:slideUp .6s .1s forwards}
        .eyebrow{display:flex;align-items:center;gap:.6rem;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel);margin-bottom:.75rem}
        .eyebrow::before{content:'';display:block;width:28px;height:1px;background:var(--caramel)}
        .page-title{font-family:'Cormorant Garamond',serif;font-size:clamp(2.8rem,5vw,4.2rem);font-weight:300;line-height:1.0;color:var(--oat);margin-bottom:.6rem}
        .page-title em{font-style:italic;color:var(--caramel);font-weight:600}
        .subtitle{font-size:.88rem;color:var(--muted);margin-bottom:2.5rem;display:flex;align-items:center;gap:.5rem}

        /* Check icon */
        .check-wrap{display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;background:rgba(181,118,42,.1);border:1px solid rgba(181,118,42,.3);margin-bottom:1.5rem}

        /* Items table */
        .items-table{width:100%;border-collapse:collapse}
        .items-table thead th{font-size:.65rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(242,234,216,.25);font-weight:400;text-align:left;padding:.5rem 0 .85rem;border-bottom:1px solid var(--border)}
        .items-table thead th:last-child{text-align:right}
        .item-row td{padding:1.1rem 0;border-bottom:1px solid var(--border);vertical-align:middle}
        .item-row:last-child td{border-bottom:none}
        .item-name{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;color:var(--oat);margin-bottom:.18rem}
        .item-unit{font-size:.75rem;color:rgba(242,234,216,.3)}
        .item-qty{font-size:.85rem;color:var(--muted);text-align:center}
        .item-subtotal{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;color:var(--oat);text-align:right;white-space:nowrap}

        /* Order meta pills */
        .order-meta{margin-top:1.8rem;display:flex;align-items:center;gap:.6rem;flex-wrap:wrap}
        .meta-pill{display:inline-flex;align-items:center;gap:.45rem;font-size:.75rem;color:rgba(242,234,216,.35);background:var(--faint);border:1px solid var(--border);padding:.4rem .9rem;border-radius:999px}

        /* Back link */
        .new-order-link{display:inline-flex;align-items:center;gap:.4rem;margin-top:2rem;font-size:.8rem;color:var(--muted);text-decoration:none;transition:color .2s}
        .new-order-link:hover{color:var(--oat)}

        /* RIGHT — Summary card */
        .summary-side{opacity:0;animation:slideUp .6s .22s forwards}
        .summary-card{background:rgba(242,234,216,.03);border:1px solid var(--border);border-radius:18px;overflow:hidden;position:sticky;top:90px}
        .summary-header{padding:1.4rem 1.6rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
        .summary-title{font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:600}
        .summary-n{font-size:.75rem;color:var(--muted)}
        .summary-body{padding:1.4rem 1.6rem}
        .summary-line{display:flex;justify-content:space-between;align-items:center;font-size:.84rem;color:var(--muted);margin-bottom:.65rem}
        .summary-line:last-of-type{margin-bottom:0}
        .summary-line span:last-child{color:rgba(242,234,216,.65)}
        .summary-divider{height:1px;background:var(--border);margin:1.2rem 0}
        .summary-total{display:flex;justify-content:space-between;align-items:baseline}
        .total-label{font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
        .total-amt{font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;color:var(--caramel)}
        .summary-footer{padding:1.2rem 1.6rem;background:rgba(242,234,216,.02);border-top:1px solid var(--border)}

        /* Status badge */
        .status-badge{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;background:rgba(100,200,100,.07);border:1px solid rgba(100,200,100,.18);color:#90d890;padding:.85rem 1rem;border-radius:12px;font-size:.82rem;font-weight:400;margin-bottom:1rem}

        /* New order btn */
        .btn-new-order{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;background:var(--caramel);color:var(--espresso);border:none;padding:1rem;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:500;letter-spacing:.02em;text-decoration:none;cursor:pointer;transition:background .2s,transform .15s,box-shadow .2s}
        .btn-new-order:hover{background:var(--caramel2);transform:translateY(-2px);box-shadow:0 8px 28px rgba(181,118,42,.3)}

        /* Walkin note */
        .walkin-note{margin-top:1rem;padding:.9rem 1rem;background:rgba(181,118,42,.06);border:1px solid rgba(181,118,42,.15);border-radius:10px;font-size:.76rem;color:rgba(242,234,216,.4);line-height:1.7;text-align:center}
        .walkin-note a{color:var(--caramel);text-decoration:none}
        .walkin-note a:hover{text-decoration:underline}

        @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){
            nav{padding:1rem 1.25rem}
            .page-wrap{grid-template-columns:1fr;padding:2rem 1.25rem 5rem;gap:2rem}
            .summary-card{position:static}
            .page-title{font-size:2.4rem}
        }
    </style>
</head>
<body>
<div class="ambient"></div>

<nav>
    <a href="{{ url('/') }}" class="nav-logo"><span class="logo-pip"></span>Brew &amp; Bean</a>
    <span class="nav-badge">Walk-in</span>
    <div style="width:90px"></div>
</nav>

<div class="page-wrap">

    {{-- LEFT: confirmation + items --}}
    <div class="success-side">

        <div class="check-wrap">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--caramel)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <p class="eyebrow">Walk-in Order</p>
        <h1 class="page-title">Order <em>placed!</em></h1>
        <p class="subtitle">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Thanks, <strong style="color:var(--oat);font-weight:500">{{ $cart->customer_name }}</strong>. Please wait for your name to be called.
        </p>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:center">Qty</th>
                    <th style="text-align:right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->orderItems as $item)
                    <tr class="item-row">
                        <td>
                            <p class="item-name">{{ $item->menuItem->name }}</p>
                            <p class="item-unit">₱{{ number_format($item->unit_price, 2) }} each</p>
                        </td>
                        <td class="item-qty">× {{ $item->quantity }}</td>
                        <td class="item-subtotal">₱{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-meta">
            <span class="meta-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Order #{{ $cart->id }}
            </span>
            <span class="meta-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                {{ ucfirst($cart->payment->method ?? 'cash') }} payment
            </span>
            <span class="meta-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Pending · awaiting staff
            </span>
        </div>

        <a href="{{ route('walkin.menu') }}" class="new-order-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Place another order
        </a>
    </div>

    {{-- RIGHT: summary card --}}
    <div class="summary-side">
        <div class="summary-card">
            <div class="summary-header">
                <h2 class="summary-title">Order Summary</h2>
                <span class="summary-n">{{ $cart->orderItems->count() }} item{{ $cart->orderItems->count() > 1 ? 's' : '' }}</span>
            </div>
            <div class="summary-body">
                @foreach($cart->orderItems as $item)
                    <div class="summary-line">
                        <span>{{ $item->menuItem->name }} ×{{ $item->quantity }}</span>
                        <span>₱{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span class="total-label">Total</span>
                    <span class="total-amt">₱{{ number_format($cart->total_amount, 2) }}</span>
                </div>
            </div>
            <div class="summary-footer">
                <div class="status-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Payment received · pending preparation
                </div>
                <a href="{{ route('walkin.menu') }}" class="btn-new-order">
                    New Order →
                </a>
                <div class="walkin-note">
                    Walk-in orders are full price.<br>
                    <a href="{{ route('register') }}">Create an account</a> to get 15% off every order.
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>