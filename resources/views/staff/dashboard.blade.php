@extends('layouts.app')

@section('title', 'Staff Dashboard')

@push('styles')
<style>
    .dashboard-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3rem 3rem 5rem;
    }

    .page-header {
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.1s forwards;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }
    .page-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--caramel);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-eyebrow::before {
        content: '';
        display: block;
        width: 28px; height: 1px;
        background: var(--caramel);
    }
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 300;
        color: var(--oat);
    }
    .page-title em { font-style: italic; font-weight: 600; color: var(--caramel); }

    /* ── Stats row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }

    .stat-card {
        background: rgba(242,234,216,0.04);
        border: 1px solid rgba(242,234,216,0.09);
        border-radius: 16px;
        padding: 1.4rem 1.6rem;
        transition: border-color 0.2s;
    }
    .stat-card:hover { border-color: rgba(181,118,42,0.25); }

    .stat-card-label {
        font-size: 0.7rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(242,234,216,0.35);
        margin-bottom: 0.5rem;
    }
    .stat-card-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.4rem;
        font-weight: 600;
        color: var(--caramel);
        line-height: 1;
        margin-bottom: 0.2rem;
    }
    .stat-card-sub {
        font-size: 0.78rem;
        color: rgba(242,234,216,0.35);
    }

    /* ── Two-column layout ── */
    .dash-grid {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 1.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.3s forwards;
    }

    .dash-section {
        background: rgba(242,234,216,0.03);
        border: 1px solid rgba(242,234,216,0.08);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .dash-section-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid rgba(242,234,216,0.07);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .dash-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--oat);
    }
    .dash-section-action {
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--caramel);
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .dash-section-action:hover { opacity: 0.7; }

    /* ── Scrollable body ── */
    .dash-section-body {
        max-height: 198px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(181,118,42,0.3) transparent;
    }
    .dash-section-body::-webkit-scrollbar {
        width: 4px;
    }
    .dash-section-body::-webkit-scrollbar-track {
        background: transparent;
    }
    .dash-section-body::-webkit-scrollbar-thumb {
        background: rgba(181,118,42,0.3);
        border-radius: 999px;
    }
    .dash-section-body::-webkit-scrollbar-thumb:hover {
        background: rgba(181,118,42,0.55);
    }

    /* ── Live orders list ── */
    .order-row {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(242,234,216,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: background 0.2s;
    }
    .order-row:last-child { border-bottom: none; }
    .order-row:hover { background: rgba(242,234,216,0.03); }

    .order-row-left { flex: 1; min-width: 0; }
    .order-id {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--oat);
        margin-bottom: 0.2rem;
    }
    .order-meta {
        font-size: 0.75rem;
        color: rgba(242,234,216,0.35);
        margin-bottom: 0.2rem;
    }
    .order-items-preview {
        font-size: 0.78rem;
        color: rgba(242,234,216,0.4);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }

    .order-badge {
        display: inline-block;
        font-size: 0.62rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        white-space: nowrap;
    }
    .badge-pending {
        background: rgba(181,118,42,0.15);
        border: 1px solid rgba(181,118,42,0.35);
        color: var(--caramel);
    }
    .badge-completed {
        background: rgba(101,180,101,0.1);
        border: 1px solid rgba(101,180,101,0.3);
        color: #8ecf8e;
    }

    .complete-form button {
        background: rgba(101,180,101,0.12);
        border: 1px solid rgba(101,180,101,0.3);
        color: #8ecf8e;
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .complete-form button:hover { background: rgba(101,180,101,0.2); }

    /* ── Menu management list ── */
    .menu-row {
        padding: 0.9rem 1.5rem;
        border-bottom: 1px solid rgba(242,234,216,0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: background 0.2s;
    }
    .menu-row:last-child { border-bottom: none; }
    .menu-row:hover { background: rgba(242,234,216,0.03); }

    .menu-row-img {
        width: 44px; height: 44px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        filter: brightness(0.82);
    }

    .menu-row-info { flex: 1; min-width: 0; }
    .menu-row-name {
        font-size: 0.9rem;
        color: var(--oat);
        margin-bottom: 0.15rem;
        font-weight: 400;
    }
    .menu-row-price {
        font-size: 0.78rem;
        color: var(--caramel);
        font-family: 'Cormorant Garamond', serif;
    }

    .menu-row-actions {
        display: flex;
        gap: 0.5rem;
    }
    .action-btn {
        font-size: 0.65rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        text-decoration: none;
        cursor: pointer;
        transition: opacity 0.2s, background 0.2s;
        border: none;
    }
    .action-edit {
        background: rgba(242,234,216,0.07);
        color: rgba(242,234,216,0.6);
        border: 1px solid rgba(242,234,216,0.12);
    }
    .action-edit:hover { background: rgba(242,234,216,0.12); color: var(--oat); }
    .action-delete {
        background: rgba(224,112,112,0.08);
        color: #e07070;
        border: 1px solid rgba(224,112,112,0.2);
    }
    .action-delete:hover { background: rgba(224,112,112,0.15); }

    /* ── Empty states ── */
    .empty-row {
        padding: 2.5rem 1.5rem;
        text-align: center;
        color: rgba(242,234,216,0.25);
        font-size: 0.85rem;
    }

    /* ── Flash ── */
    .alert-success {
        margin-bottom: 1.5rem;
        padding: 0.8rem 1.2rem;
        border-radius: 10px;
        font-size: 0.84rem;
        background: rgba(100,200,100,0.08);
        border: 1px solid rgba(100,200,100,0.2);
        color: #90d890;
    }

    @media (max-width: 900px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .dash-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .dashboard-page { padding: 2rem 1.5rem 4rem; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    }
</style>
@endpush

@section('content')

<div class="dashboard-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Staff Area</p>
            <h1 class="page-title"><em>Dashboard</em></h1>
        </div>
        <a href="{{ route('staff.menu.create') }}" class="btn-primary">+ New Menu Item</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-card-label">Today's Orders</p>
            <p class="stat-card-num">{{ $todayOrders ?? 0 }}</p>
            <p class="stat-card-sub">orders placed today</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Pending</p>
            <p class="stat-card-num">{{ $pendingOrders ?? 0 }}</p>
            <p class="stat-card-sub">awaiting completion</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Revenue Today</p>
            <p class="stat-card-num">₱{{ number_format($todayRevenue ?? 0, 0) }}</p>
            <p class="stat-card-sub">from paid orders</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Menu Items</p>
            <p class="stat-card-num">{{ $menuItems->where('is_available', true)->count() }}</p>
            <p class="stat-card-sub">active items</p>
        </div>
    </div>

    {{-- Main grid --}}
    <div class="dash-grid">

        {{-- Live Orders --}}
        <div class="dash-section">
            <div class="dash-section-header">
                <p class="dash-section-title">Live Orders</p>
                <a href="{{ route('staff.orders.index') }}" class="dash-section-action">View all &rarr;</a>
            </div>

            <div class="dash-section-body">
                @forelse($liveOrders ?? [] as $order)
                    <div class="order-row">
                        <div class="order-row-left">
                            <p class="order-id">
                                Order #{{ $order->id }}
                                @if($order->is_walkin)
                                    &nbsp;<span class="order-badge badge-pending" style="font-size:.55rem">Walk-in</span>
                                @endif
                            </p>
                            <p class="order-meta">
                                {{ $order->is_walkin ? ($order->customer_name ?? 'Walk-in customer') : ($order->user?->name ?? '—') }}
                                &middot; ₱{{ number_format($order->total_amount, 2) }}
                                &middot; {{ $order->payment?->method ?? '—' }}
                            </p>
                            <p class="order-items-preview">
                                {{ $order->orderItems->map(fn($i) => $i->menuItem->name . ' ×' . $i->quantity)->join(', ') }}
                            </p>
                        </div>

                        {{-- Status badge --}}
                        @if($order->status === 'pending')
                            <span class="order-badge badge-pending">Pending</span>
                        @else
                            <span class="order-badge badge-completed">Completed</span>
                        @endif

                        {{-- Mark complete button — only for pending orders --}}
                        @if($order->status === 'pending')
                            <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST" class="complete-form">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit">Mark Ready ✓</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="empty-row">No active orders right now</div>
                @endforelse
            </div>
        </div>

        {{-- Menu Management --}}
        <div class="dash-section">
            <div class="dash-section-header">
                <p class="dash-section-title">Menu Items</p>
                <a href="{{ route('staff.menu.create') }}" class="dash-section-action">+ Add item</a>
            </div>

            <div class="dash-section-body">
                @forelse($menuItems ?? [] as $item)
                    <div class="menu-row">
                        @if($item->image)
                            <img class="menu-row-img" src="{{ $item->image }}" alt="{{ $item->name }}">
                        @else
                            <img class="menu-row-img" src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100&q=60" alt="{{ $item->name }}">
                        @endif
                        <div class="menu-row-info">
                            <p class="menu-row-name">{{ $item->name }}</p>
                            <p class="menu-row-price">₱{{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="menu-row-actions">
                            <a href="{{ route('staff.menu.edit', $item->id) }}" class="action-btn action-edit">Edit</a>
                            <form action="{{ route('staff.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete {{ $item->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-row">No menu items yet — add your first one!</div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection