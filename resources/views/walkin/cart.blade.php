<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart · Brew & Bean</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root{--espresso:#1c100a;--roast:#3b1f10;--caramel:#b5762a;--caramel2:#c98830;--oat:#f2ead8;--muted:rgba(242,234,216,.45);--faint:rgba(242,234,216,.06);--border:rgba(242,234,216,.09)}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{background:var(--espresso);color:var(--oat);font-family:'DM Sans',sans-serif;font-weight:300;min-height:100vh}
        body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");opacity:.035;pointer-events:none;z-index:999}

        /* NAV */
        nav{position:sticky;top:0;z-index:50;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 2.5rem;background:rgba(28,16,10,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
        .nav-logo{font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:600;color:var(--oat);text-decoration:none;display:flex;align-items:center;gap:.5rem}
        .logo-pip{width:7px;height:7px;border-radius:50%;background:var(--caramel)}
        .back-link{display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;padding:.48rem 1rem;border:1px solid var(--border);border-radius:999px;transition:color .2s,border-color .2s}
        .back-link:hover{color:var(--oat);border-color:rgba(242,234,216,.2)}

        /* LAYOUT */
        .page-wrap{max-width:980px;margin:0 auto;padding:3rem 2.5rem 6rem;display:grid;grid-template-columns:1fr 360px;gap:3rem;align-items:start}

        /* LEFT SIDE */
        .cart-side{opacity:0;animation:slideUp .6s .1s forwards}
        .eyebrow{display:flex;align-items:center;gap:.6rem;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel);margin-bottom:.65rem}
        .eyebrow::before{content:'';display:block;width:24px;height:1px;background:var(--caramel)}
        .page-title{font-family:'Cormorant Garamond',serif;font-size:clamp(2.2rem,4vw,3rem);font-weight:300;line-height:1;margin-bottom:2.5rem}
        .page-title em{font-style:italic;color:var(--caramel);font-weight:600}

        /* Cart items table */
        .items-table{width:100%;border-collapse:collapse}
        .items-table thead th{font-size:.65rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(242,234,216,.25);font-weight:400;text-align:left;padding:.5rem 0 .85rem;border-bottom:1px solid var(--border)}
        .items-table thead th:last-child{text-align:right}
        .item-row td{padding:1.2rem 0;border-bottom:1px solid var(--border);vertical-align:middle}
        .item-row:last-child td{border-bottom:none}
        .item-info-name{font-family:'Cormorant Garamond',serif;font-size:1.18rem;font-weight:600;color:var(--oat);margin-bottom:.2rem}
        .item-info-unit{font-size:.76rem;color:rgba(242,234,216,.3)}

        /* Qty stepper */
        .stepper{display:inline-flex;align-items:center;background:var(--faint);border:1px solid var(--border);border-radius:999px;overflow:hidden}
        .step-btn{background:none;border:none;color:var(--muted);width:32px;height:32px;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:color .15s,background .15s}
        .step-btn:hover{color:var(--oat);background:rgba(242,234,216,.08)}
        .step-num{min-width:28px;text-align:center;font-size:.88rem;color:var(--oat)}

        .item-subtotal{font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--oat);text-align:right;white-space:nowrap}

        /* Remove btn */
        .remove-btn{background:none;border:none;color:rgba(242,234,216,.18);cursor:pointer;padding:.3rem;border-radius:6px;transition:color .2s,background .2s;display:flex;align-items:center;justify-content:center;margin-left:.5rem}
        .remove-btn:hover{color:#e07070;background:rgba(220,80,80,.08)}

        /* Continue */
        .continue-link{display:inline-flex;align-items:center;gap:.4rem;margin-top:1.5rem;font-size:.8rem;color:var(--muted);text-decoration:none;transition:color .2s}
        .continue-link:hover{color:var(--oat)}

        /* Empty cart */
        .empty-cart{text-align:center;padding:5rem 0;grid-column:1/-1;opacity:0;animation:slideUp .6s .1s forwards}
        .empty-icon{font-size:4rem;margin-bottom:1.2rem;display:block}
        .empty-title{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:rgba(242,234,216,.45);margin-bottom:.5rem}
        .empty-sub{font-size:.85rem;color:rgba(242,234,216,.25);margin-bottom:2rem}
        .btn-go{display:inline-flex;align-items:center;gap:.4rem;background:var(--caramel);color:var(--espresso);text-decoration:none;padding:.85rem 2rem;border-radius:999px;font-size:.85rem;font-weight:500;transition:background .2s,transform .15s}
        .btn-go:hover{background:var(--caramel2);transform:translateY(-1px)}

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

        /* Checkout btn */
        .btn-checkout{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;background:var(--caramel);color:var(--espresso);border:none;padding:1rem;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:500;letter-spacing:.02em;text-decoration:none;cursor:pointer;transition:background .2s,transform .15s,box-shadow .2s}
        .btn-checkout:hover{background:var(--caramel2);transform:translateY(-2px);box-shadow:0 8px 28px rgba(181,118,42,.3)}

        /* Walkin note */
        .walkin-note{margin-top:1rem;padding:.9rem 1rem;background:rgba(181,118,42,.06);border:1px solid rgba(181,118,42,.15);border-radius:10px;font-size:.76rem;color:rgba(242,234,216,.4);line-height:1.7;text-align:center}
        .walkin-note a{color:var(--caramel);text-decoration:none}
        .walkin-note a:hover{text-decoration:underline}

        @keyframes slideUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){
            nav{padding:1rem 1.25rem}
            .page-wrap{grid-template-columns:1fr;padding:2rem 1.25rem 5rem;gap:2rem}
            .summary-card{position:static}
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ url('/') }}" class="nav-logo"><span class="logo-pip"></span>Brew &amp; Bean</a>
    <a href="{{ route('walkin.menu') }}" class="back-link">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Menu
    </a>
</nav>

<div class="page-wrap">
    @if($orderItems->isEmpty())
        <div class="empty-cart">
            <h2 class="empty-title">Your cart is empty</h2>
            <p class="empty-sub">Head back to the menu and add something delicious.</p>
            <a href="{{ route('walkin.menu') }}" class="btn-go">Browse Menu →</a>
        </div>
    @else

        {{-- LEFT: items --}}
        <div class="cart-side">
            <p class="eyebrow">Walk-in Order</p>
            <h1 class="page-title">Your <em>cart</em></h1>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                        <tr class="item-row">
                            <td>
                                <p class="item-info-name">{{ $item->menuItem->name }}</p>
                                <p class="item-info-unit">₱{{ number_format($item->unit_price, 2) }} each</p>
                            </td>
                            <td style="text-align:center">
                                {{-- Decrease --}}
                                <div style="display:flex;align-items:center;justify-content:center;gap:.3rem">
                                    <form action="{{ route('walkin.items.update', [$order, $item]) }}" method="POST" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="step-btn" style="background:var(--faint);border:1px solid var(--border);border-radius:999px;width:30px;height:30px">−</button>
                                    </form>
                                    <span class="step-num">{{ $item->quantity }}</span>
                                    <form action="{{ route('walkin.items.update', [$order, $item]) }}" method="POST" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="step-btn" style="background:var(--faint);border:1px solid var(--border);border-radius:999px;width:30px;height:30px">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="item-subtotal">₱{{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('walkin.items.destroy', [$order, $item]) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="remove-btn" title="Remove item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('walkin.menu') }}" class="continue-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Continue shopping
            </a>
        </div>

        {{-- RIGHT: summary --}}
        <div class="summary-side">
            <div class="summary-card">
                <div class="summary-header">
                    <h2 class="summary-title">Order Summary</h2>
                    <span class="summary-n">{{ $orderItems->count() }} item{{ $orderItems->count() > 1 ? 's' : '' }}</span>
                </div>
                <div class="summary-body">
                    @foreach($orderItems as $item)
                        <div class="summary-line">
                            <span>{{ $item->menuItem->name }} ×{{ $item->quantity }}</span>
                            <span>₱{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <span class="total-label">Total</span>
                        <span class="total-amt">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>
                <div class="summary-footer">
                    <a href="{{ route('walkin.checkout') }}" class="btn-checkout">
                        Proceed to Checkout
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    <div class="walkin-note">
                        Walk-in orders are full price.<br>
                        <a href="{{ route('register') }}">Create an account</a> to get 15% off every order.
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>

</body>
</html>