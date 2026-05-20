<x-guest-layout>
<style>
    :root {
        --espresso:  #1c100a;
        --roast:     #3b1f10;
        --caramel:   #b5762a;
        --oat:       #f2ead8;
        --muted:     rgba(242,234,216,0.45);
        --border:    rgba(242,234,216,0.1);
        --input-bg:  rgba(242,234,216,0.05);
    }

    /* ── Page shell ── */
    body, html {
        margin: 0; padding: 0;
        min-height: 100vh;
        background: var(--espresso);
        font-family: 'DM Sans', sans-serif;
        font-weight: 300;
        color: var(--oat);
    }

    /* ── Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,600&family=DM+Sans:wght@300;400;500&display=swap');

    /* ── Grain ── */
    body::before {
        content: '';
        position: fixed; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
        opacity: 0.04; pointer-events: none; z-index: 0;
    }

    /* ── Glow ── */
    body::after {
        content: '';
        position: fixed;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(181,118,42,0.14) 0%, transparent 70%);
        top: -100px; right: -100px;
        pointer-events: none; z-index: 0;
        animation: glow-pulse 8s ease-in-out infinite;
    }
    @keyframes glow-pulse {
        0%,100% { opacity: 0.7; transform: scale(1); }
        50%      { opacity: 1;   transform: scale(1.1); }
    }

    /* ── Layout ── */
    .auth-wrapper {
        position: relative; z-index: 1;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .auth-panel {
        width: 100%; max-width: 560px;
        background: rgba(242,234,216,0.03);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2.5rem 2.25rem;
        animation: fade-up 0.7s ease forwards;
    }
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Logo ── */
    .auth-logo {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.55rem; font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.25rem;
        text-decoration: none;
    }
    .logo-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--caramel); flex-shrink: 0;
        margin-bottom: 2px;
    }
    .auth-tagline {
        font-size: 0.8rem; letter-spacing: 0.06em;
        color: var(--muted); margin-bottom: 2rem;
    }
    .auth-heading {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.9rem; font-weight: 300;
        color: var(--oat); margin-bottom: 1.75rem;
        line-height: 1.2;
    }
    .auth-heading em { font-style: italic; color: var(--caramel); }

    /* ── Session status ── */
    .session-status {
        background: rgba(181,118,42,0.12);
        border: 1px solid rgba(181,118,42,0.3);
        border-radius: 8px;
        padding: 0.65rem 1rem;
        font-size: 0.82rem;
        color: var(--caramel);
        margin-bottom: 1.25rem;
    }

    /* ── Form fields ── */
    .field { margin-bottom: 1.1rem; }

    .field-label {
        display: block;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.45rem;
    }

    /* Override Breeze x-text-input styles */
    .field input[type="email"],
    .field input[type="password"],
    .field input[type="text"] {
        width: 100% !important;
        background: var(--input-bg) !important;
        border: 1px solid var(--border) !important;
        border-radius: 10px !important;
        padding: 0.75rem 1rem !important;
        font-family: 'DM Sans', sans-serif !important;
        font-size: 0.9rem !important;
        font-weight: 300 !important;
        color: var(--oat) !important;
        outline: none !important;
        transition: border-color 0.2s, background 0.2s !important;
        box-shadow: none !important;
    }
    .field input:focus {
        border-color: rgba(181,118,42,0.55) !important;
        background: rgba(242,234,216,0.08) !important;
    }
    .field input::placeholder { color: rgba(242,234,216,0.25) !important; }

    /* Breeze error messages */
    .field-error {
        font-size: 0.78rem;
        color: #e07070;
        margin-top: 0.35rem;
    }

    /* ── Remember me ── */
    .remember-row {
        display: flex; align-items: center; gap: 0.6rem;
        margin-bottom: 1.5rem;
    }
    .remember-row input[type="checkbox"] {
        width: 15px; height: 15px;
        border-radius: 4px;
        accent-color: var(--caramel);
        cursor: pointer;
    }
    .remember-row label {
        font-size: 0.82rem;
        color: var(--muted);
        cursor: pointer;
        user-select: none;
    }

    /* ── Actions ── */
    .auth-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .link-muted {
        font-size: 0.78rem;
        color: var(--muted);
        text-decoration: none;
        transition: color 0.2s;
    }
    .link-muted:hover { color: var(--oat); }

    /* Override Breeze x-primary-button */
    button[type="submit"],
    .btn-submit {
        background: var(--caramel) !important;
        color: var(--espresso) !important;
        border: none !important;
        padding: 0.75rem 2rem !important;
        border-radius: 999px !important;
        font-family: 'DM Sans', sans-serif !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        letter-spacing: 0.04em !important;
        cursor: pointer !important;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s !important;
        box-shadow: none !important;
    }
    button[type="submit"]:hover {
        background: #c98830 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(181,118,42,0.3) !important;
    }

    /* ── Divider ── */
    .auth-divider {
        display: flex; align-items: center; gap: 0.75rem;
        margin: 1.5rem 0;
    }
    .auth-divider::before, .auth-divider::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }
    .auth-divider span {
        font-size: 0.72rem; letter-spacing: 0.1em;
        text-transform: uppercase; color: var(--muted);
    }

    .register-link {
        display: block; text-align: center;
        font-size: 0.82rem; color: var(--muted);
        text-decoration: none;
    }
    .register-link a { color: var(--caramel); text-decoration: none; transition: opacity 0.2s; }
    .register-link a:hover { opacity: 0.8; }
</style>

<div class="auth-wrapper">
    <div class="auth-panel">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="auth-logo">
            <span class="logo-dot"></span>
            Brew &amp; Bean
        </a>
        <p class="auth-tagline">Specialty Coffee &mdash; Est. 2026</p>

        <h1 class="auth-heading">Welcome<em> Back</em></h1>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="field">
                <label class="field-label" for="email">Email address</label>
                <x-text-input id="email" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username"
                    placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="field-error" />
            </div>

            {{-- Password --}}
            <div class="field">
                <label class="field-label" for="password">Password</label>
                <x-text-input id="password" type="password" name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="field-error" />
            </div>

            {{-- Remember me --}}
            <div class="remember-row">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Keep me signed in</label>
            </div>

            {{-- Actions --}}
            <div class="auth-actions">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-muted">
                        Forgot password?
                    </a>
                @endif
                <x-primary-button>Sign in</x-primary-button>
            </div>
        </form>

        <div class="auth-divider"><span>or</span></div>

        <p class="register-link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </p>

    </div>
</div>
</x-guest-layout>