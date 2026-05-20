<nav x-data="{ open: false }">
<style>
    :root {
        --espresso: #1c100a;
        --caramel:  #b5762a;
        --oat:      #f2ead8;
        --muted:    rgba(242,234,216,0.45);
        --border:   rgba(242,234,216,0.08);
    }

    .bb-nav {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2.5rem;
        height: 64px;
        backdrop-filter: blur(12px);
        background: rgba(28,16,10,0.85);
        border-bottom: 1px solid var(--border);
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Logo ── */
    .bb-logo {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem; font-weight: 600;
        color: var(--oat);
        text-decoration: none;
        flex-shrink: 0;
    }
    .bb-logo-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--caramel);
        margin-bottom: 2px; flex-shrink: 0;
    }

    /* ── Links ── */
    .bb-links {
        display: flex; align-items: center; gap: 0.25rem;
    }

    .bb-link {
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        text-decoration: none;
        padding: 0.5rem 0.85rem;
        border-radius: 999px;
        transition: color 0.2s, background 0.2s;
        display: flex; align-items: center; gap: 0.4rem;
        white-space: nowrap;
    }
    .bb-link:hover {
        color: var(--oat);
        background: rgba(242,234,216,0.06);
    }
    .bb-link.active {
        color: var(--caramel);
    }

    /* Cart badge */
    .cart-badge {
        background: var(--caramel);
        color: var(--espresso);
        font-size: 0.65rem;
        font-weight: 600;
        width: 18px; height: 18px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        line-height: 1;
    }

    /* ── Right side ── */
    .bb-right {
        display: flex; align-items: center; gap: 0.5rem;
    }

    /* User name */
    .bb-user {
        font-size: 0.78rem;
        color: var(--muted);
        padding: 0 0.5rem;
    }

    /* Sign out button */
    .bb-signout {
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem 0.85rem;
        border-radius: 999px;
        font-family: 'DM Sans', sans-serif;
        transition: color 0.2s, background 0.2s;
    }
    .bb-signout:hover {
        color: var(--oat);
        background: rgba(242,234,216,0.06);
    }

    /* Divider */
    .bb-divider {
        width: 1px; height: 20px;
        background: var(--border);
        margin: 0 0.25rem;
    }

    /* ── Mobile hamburger ── */
    .bb-hamburger {
        display: none;
        background: none; border: none;
        color: var(--muted); cursor: pointer;
        padding: 0.5rem;
    }

    /* ── Mobile menu ── */
    .bb-mobile {
        display: none;
        position: fixed;
        top: 64px; left: 0; right: 0;
        background: rgba(28,16,10,0.97);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.5rem 1.5rem;
        z-index: 49;
        flex-direction: column;
        gap: 0.25rem;
    }
    .bb-mobile.open { display: flex; }
    .bb-mobile .bb-link { font-size: 0.85rem; padding: 0.75rem 1rem; }
    .bb-mobile-user {
        font-size: 0.78rem; color: var(--muted);
        padding: 0.75rem 1rem 0.5rem;
        border-top: 1px solid var(--border);
        margin-top: 0.5rem;
    }

    @media (max-width: 640px) {
        .bb-nav { padding: 0 1.25rem; }
        .bb-links, .bb-right { display: none; }
        .bb-hamburger { display: block; }
    }

    /* Push page content below fixed nav */
    body { padding-top: 64px; }
</style>

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<div class="bb-nav">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="bb-logo">
        <span class="bb-logo-dot"></span>
        Brew &amp; Bean
    </a>

    {{-- Center links --}}
    @auth
        @if(Auth::user()->isCustomer())
            <div class="bb-links">
                {{-- Back arrow --}}
                <a href="{{ route('dashboard') }}" class="bb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    &#8249;
                </a>

                <a href="{{ route('menu.index') }}" class="bb-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    Menu
                </a>

                <a href="{{ route('orders.index') }}" class="bb-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    My Orders
                </a>

                <a href="{{ route('orders.cart') }}" class="bb-link {{ request()->routeIs('orders.cart') ? 'active' : '' }}">
                    Cart
                    @php $cartCount = count(session()->get('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        @elseif(Auth::user()->isStaff())
            <div class="bb-links">
                <a href="{{ route('staff.menu.index') }}" class="bb-link {{ request()->routeIs('staff.menu.*') ? 'active' : '' }}">
                    Manage Menu
                </a>
            </div>
        @endif
    @endauth

    {{-- Right: user + sign out --}}
    @auth
        <div class="bb-right">
            <span class="bb-user">{{ Auth::user()->name }}</span>
            <div class="bb-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bb-signout">Sign out</button>
            </form>
        </div>
    @endauth

    {{-- Mobile hamburger --}}
    <button class="bb-hamburger" onclick="toggleMobile()" aria-label="Toggle menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
</div>

{{-- Mobile menu --}}
@auth
<div class="bb-mobile" id="bb-mobile-menu">
    @if(Auth::user()->isCustomer())
        <a href="{{ route('menu.index') }}"   class="bb-link {{ request()->routeIs('menu.*')       ? 'active' : '' }}">Menu</a>
        <a href="{{ route('orders.index') }}" class="bb-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">My Orders</a>
        <a href="{{ route('orders.cart') }}"  class="bb-link {{ request()->routeIs('orders.cart')  ? 'active' : '' }}">Cart</a>
    @elseif(Auth::user()->isStaff())
        <a href="{{ route('staff.menu.index') }}" class="bb-link {{ request()->routeIs('staff.menu.*') ? 'active' : '' }}">Manage Menu</a>
    @endif
    <div class="bb-mobile-user">{{ Auth::user()->name }} &mdash; {{ Auth::user()->email }}</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bb-link bb-signout" style="width:100%;text-align:left">Sign out</button>
    </form>
</div>
@endauth

<script>
function toggleMobile() {
    document.getElementById('bb-mobile-menu').classList.toggle('open');
}
</script>
</nav>