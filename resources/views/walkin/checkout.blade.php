<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout · Brew & Bean</title>
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
        .nav-back{display:flex;align-items:center;gap:.55rem;text-decoration:none;color:var(--oat);background:var(--faint);border:1px solid var(--border);padding:.5rem 1.1rem;border-radius:999px;font-size:.8rem;font-weight:400;transition:background .2s,border-color .2s}
        .nav-back:hover{background:rgba(242,234,216,.1);border-color:rgba(242,234,216,.18)}

        /* HERO STRIP */
        .hero-strip{padding:3.5rem 2.5rem 2rem;max-width:900px;margin:0 auto;opacity:0;animation:slideUp .7s .05s forwards}
        .eyebrow{display:flex;align-items:center;gap:.6rem;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel);margin-bottom:.75rem}
        .eyebrow::before{content:'';display:block;width:28px;height:1px;background:var(--caramel)}
        .page-title{font-family:'Cormorant Garamond',serif;font-size:clamp(2.8rem,5vw,4.2rem);font-weight:300;line-height:1.0;color:var(--oat)}
        .page-title em{font-style:italic;color:var(--caramel);font-weight:600}

        /* LAYOUT */
        .checkout-body{max-width:900px;margin:0 auto;padding:0 2.5rem 6rem;display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:start}

        /* PANELS */
        .panel{background:var(--faint);border:1px solid var(--border);border-radius:20px;padding:2rem;opacity:0}
        .panel:nth-child(1){animation:slideUp .6s .15s forwards}
        .panel:nth-child(2){animation:slideUp .6s .25s forwards}
        .panel-title{font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel);margin-bottom:1.5rem;display:flex;align-items:center;gap:.6rem}
        .panel-title::after{content:'';flex:1;height:1px;background:var(--border)}

        /* ORDER SUMMARY */
        .order-line{display:flex;align-items:center;justify-content:space-between;padding:.65rem 0;border-bottom:1px solid var(--border)}
        .order-line:last-of-type{border-bottom:none}
        .order-line-name{font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-weight:400;color:var(--oat)}
        .order-line-qty{font-size:.75rem;color:var(--muted);margin-top:.1rem}
        .order-line-price{font-family:'Cormorant Garamond',serif;font-size:1.1rem;color:var(--oat);white-space:nowrap}
        .order-total-row{display:flex;justify-content:space-between;align-items:baseline;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid rgba(181,118,42,.25)}
        .order-total-label{font-size:.78rem;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
        .order-total-amount{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:var(--caramel)}

        /* FORM */
        .field{margin-bottom:1.4rem}
        .field label{display:block;font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:.55rem}
        .field input{width:100%;background:rgba(242,234,216,.04);border:1px solid var(--border);border-radius:12px;padding:.85rem 1rem;color:var(--oat);font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:300;outline:none;transition:border-color .2s,background .2s}
        .field input::placeholder{color:rgba(242,234,216,.2)}
        .field input:focus{border-color:rgba(181,118,42,.5);background:rgba(181,118,42,.04)}
        .field-error{font-size:.75rem;color:#e07070;margin-top:.4rem}

        /* PAYMENT METHOD */
        .pay-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:.6rem;margin-top:.1rem}
        .pay-option input[type=radio]{display:none}
        .pay-option label{display:flex;flex-direction:column;align-items:center;gap:.4rem;padding:.9rem .5rem;border:1px solid var(--border);border-radius:14px;cursor:pointer;transition:all .2s;background:rgba(242,234,216,.03);font-size:.72rem;color:var(--muted);letter-spacing:.06em;text-transform:uppercase}
        .pay-option label .pay-icon{font-size:1.4rem;line-height:1}
        .pay-option input:checked + label{border-color:var(--caramel);background:rgba(181,118,42,.1);color:var(--caramel)}
        .pay-option label:hover{border-color:rgba(181,118,42,.35);background:rgba(181,118,42,.05);color:rgba(242,234,216,.7)}

        /* SUBMIT */
        .btn-place{width:100%;margin-top:1.75rem;background:var(--caramel);color:var(--espresso);border:none;padding:1rem 1.5rem;border-radius:14px;font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:500;letter-spacing:.05em;cursor:pointer;transition:background .2s,transform .15s,box-shadow .2s;display:flex;align-items:center;justify-content:center;gap:.5rem}
        .btn-place:hover{background:var(--caramel2);transform:translateY(-2px);box-shadow:0 8px 28px rgba(181,118,42,.4)}
        .btn-place:active{transform:translateY(0)}

        /* FLASH */
        .flash{max-width:900px;margin:0 auto 1rem;padding:.8rem 1.2rem;border-radius:10px;font-size:.84rem;background:rgba(200,80,80,.08);border:1px solid rgba(200,80,80,.2);color:#e09090;display:flex;align-items:center;gap:.5rem}

        /* WALKIN NOTE */
        .walkin-note{margin-top:1.1rem;font-size:.75rem;color:rgba(242,234,216,.25);text-align:center;line-height:1.6}
        .walkin-note a{color:var(--caramel);text-decoration:none}
        .walkin-note a:hover{text-decoration:underline}

        @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){
            nav{padding:1rem 1.25rem}
            .hero-strip{padding:2rem 1.25rem 1.5rem}
            .checkout-body{padding:0 1.25rem 5rem;grid-template-columns:1fr}
        }
    </style>
</head>
<body>
<div class="ambient"></div>

<nav>
    <a href="{{ url('/') }}" class="nav-logo"><span class="logo-pip"></span>Brew &amp; Bean</a>
    <span class="nav-badge">Walk-in</span>
    <a href="{{ route('walkin.cart') }}" class="nav-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Cart
    </a>
</nav>

<div class="hero-strip">
    <p class="eyebrow">Walk-in Order</p>
    <h1 class="page-title">Almost <em>there.</em></h1>
</div>

@if($errors->any())
    <div style="max-width:900px;margin:0 auto;padding:0 2.5rem">
        <div class="flash">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Please fix the errors below before continuing.
        </div>
    </div>
@endif

<div class="checkout-body">

    {{-- ORDER SUMMARY --}}
    <div class="panel">
        <div class="panel-title">Order Summary</div>

        @foreach ($cart->orderItems as $item)
            <div class="order-line">
                <div>
                    <div class="order-line-name">{{ $item->menuItem->name }}</div>
                    <div class="order-line-qty">× {{ $item->quantity }} &nbsp;·&nbsp; ₱{{ number_format($item->unit_price, 2) }} each</div>
                </div>
                <div class="order-line-price">₱{{ number_format($item->subtotal, 2) }}</div>
            </div>
        @endforeach

        <div class="order-total-row">
            <span class="order-total-label">Total</span>
            <span class="order-total-amount">₱{{ number_format($cart->total_amount, 2) }}</span>
        </div>
    </div>

    {{-- CHECKOUT FORM --}}
    <div class="panel">
        <div class="panel-title">Your Details</div>

        <form method="POST" action="{{ route('walkin.checkout.store') }}">
            @csrf

            <div class="field">
                <label for="customer_name">Your Name</label>
                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    placeholder="e.g. Juan Dela Cruz"
                    required
                    autocomplete="off"
                >
                @error('customer_name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Payment Method</label>
                <div class="pay-grid">
                    <div class="pay-option">
                        <input type="radio" name="payment_method" id="pay_cash" value="cash" {{ old('payment_method','cash') === 'cash' ? 'checked' : '' }}>
                        <label for="pay_cash">
                            Cash
                        </label>
                    </div>
                    <div class="pay-option">
                        <input type="radio" name="payment_method" id="pay_gcash" value="gcash" {{ old('payment_method') === 'gcash' ? 'checked' : '' }}>
                        <label for="pay_gcash">
                            GCash
                        </label>
                    </div>
                    <div class="pay-option">
                        <input type="radio" name="payment_method" id="pay_card" value="card" {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                        <label for="pay_card">

                            Card
                        </label>
                    </div>
                </div>
                @error('payment_method')
                    <div class="field-error" style="margin-top:.5rem">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-place">
                Place Order
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>

        <p class="walkin-note">
            Walk-in orders are full price.<br>
            <a href="{{ route('register') }}">Create an account</a> to get 15% off every order.
        </p>
    </div>

</div>

</body>
</html>