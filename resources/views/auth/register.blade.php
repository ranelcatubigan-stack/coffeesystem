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

    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,600&family=DM+Sans:wght@300;400;500&display=swap');

    body, html {
        margin: 0; padding: 0;
        min-height: 100vh;
        background: var(--espresso);
        font-family: 'DM Sans', sans-serif;
        font-weight: 300;
        color: var(--oat);
    }

    body::before {
        content: '';
        position: fixed; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
        opacity: 0.04; pointer-events: none; z-index: 0;
    }

    body::after {
        content: '';
        position: fixed;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(181,118,42,0.14) 0%, transparent 70%);
        bottom: -100px; left: -100px;
        pointer-events: none; z-index: 0;
        animation: glow-pulse 8s ease-in-out infinite;
    }
    @keyframes glow-pulse {
        0%,100% { opacity: 0.7; transform: scale(1); }
        50%      { opacity: 1;   transform: scale(1.1); }
    }

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
        color: var(--oat); margin-bottom: 0.35rem;
        line-height: 1.15;
    }
    .auth-heading em { font-style: italic; color: var(--caramel); }
    .auth-subheading {
        font-size: 0.82rem; color: var(--muted);
        margin-bottom: 1.75rem;
        line-height: 1.6;
    }

    /* ── Two-column grid for name + email ── */
    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.1rem;
    }
    @media (max-width: 480px) {
        .field-row { grid-template-columns: 1fr; }
    }

    .field { margin-bottom: 1.1rem; }
    .field.no-mb { margin-bottom: 0; }

    .field-label {
        display: block;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.45rem;
    }

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

    .field-error {
        font-size: 0.78rem;
        color: #e07070;
        margin-top: 0.35rem;
    }

    /* ── Password strength indicator ── */
    .strength-bar {
        height: 3px;
        border-radius: 999px;
        background: var(--border);
        margin-top: 0.5rem;
        overflow: hidden;
    }
    .strength-fill {
        height: 100%;
        border-radius: 999px;
        width: 0%;
        transition: width 0.3s, background 0.3s;
    }
    .strength-label {
        font-size: 0.7rem;
        color: var(--muted);
        margin-top: 0.3rem;
        min-height: 1em;
    }

    /* ── Terms note ── */
    .terms-note {
        font-size: 0.75rem;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        padding: 0.75rem 1rem;
        background: rgba(242,234,216,0.03);
        border: 1px solid var(--border);
        border-radius: 10px;
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

    button[type="submit"] {
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

    .login-link {
        display: block; text-align: center;
        font-size: 0.82rem; color: var(--muted);
        text-decoration: none;
    }
    .login-link a { color: var(--caramel); text-decoration: none; transition: opacity 0.2s; }
    .login-link a:hover { opacity: 0.8; }
</style>

<div class="auth-wrapper">
    <div class="auth-panel">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="auth-logo">
            <span class="logo-dot"></span>
            Brew &amp; Bean
        </a>
        <p class="auth-tagline">Specialty Coffee &mdash; Est. 2026</p>

        <h1 class="auth-heading">Create your <em>Account</em></h1>
        <p class="auth-subheading">Join us and start ordering your favourite brews in seconds.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name + Email side by side --}}
            <div class="field-row">
                <div class="field no-mb">
                    <label class="field-label" for="name">Full name</label>
                    <x-text-input id="name" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name"
                        placeholder="Juan dela Cruz" />
                    <x-input-error :messages="$errors->get('name')" class="field-error" />
                </div>
                <div class="field no-mb">
                    <label class="field-label" for="email">Email</label>
                    <x-text-input id="email" type="email" name="email"
                        :value="old('email')" required autocomplete="username"
                        placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="field-error" />
                </div>
            </div>

            {{-- Password --}}
            <div class="field" style="margin-top:1.1rem">
                <label class="field-label" for="password">Password</label>
                <x-text-input id="password" type="password" name="password"
                    required autocomplete="new-password"
                    placeholder="••••••••"
                    oninput="checkStrength(this.value)" />
                <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                <p class="strength-label" id="strength-label"></p>
                <x-input-error :messages="$errors->get('password')" class="field-error" />
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label class="field-label" for="password_confirmation">Confirm password</label>
                <x-text-input id="password_confirmation" type="password"
                    name="password_confirmation"
                    required autocomplete="new-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="field-error" />
            </div>

            {{-- Actions --}}
            <div class="auth-actions">
                <a href="{{ route('login') }}" class="link-muted">Already have an account?</a>
                <x-primary-button>Create account</x-primary-button>
            </div>
        </form>

        <div class="auth-divider"><span>or</span></div>

        <p class="login-link">
            Returning customer? <a href="{{ route('login') }}">Sign in instead</a>
        </p>

    </div>
</div>

<script>
function checkStrength(val) {
    const fill  = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    let score = 0;
    if (val.length >= 8)  score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '0%',   color: 'transparent', text: '' },
        { pct: '25%',  color: '#e07070',     text: 'Weak' },
        { pct: '50%',  color: '#e09c40',     text: 'Fair' },
        { pct: '75%',  color: '#b5762a',     text: 'Good' },
        { pct: '100%', color: '#5daa85',     text: 'Strong' },
    ];
    const l = levels[score];
    fill.style.width      = val.length ? l.pct   : '0%';
    fill.style.background = val.length ? l.color : 'transparent';
    label.textContent     = val.length ? l.text  : '';
    label.style.color     = l.color;
}
</script>
</x-guest-layout>