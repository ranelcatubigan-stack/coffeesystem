@extends('layouts.app')

@section('title', 'All Orders')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:3rem">

    <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:300;margin-bottom:2rem;">
        All <em style="font-style:italic;color:var(--caramel);">Orders</em>
    </h1>

    @foreach($orders as $order)
        <div style="background:rgba(242,234,216,0.04);border:1px solid rgba(242,234,216,0.09);border-radius:14px;padding:1.2rem 1.5rem;margin-bottom:0.75rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;">Order #{{ $order->id }}</div>
                <div style="font-size:0.8rem;color:rgba(242,234,216,0.4);margin-top:0.25rem;">
                    {{ $order->customer_name ?? $order->user?->name ?? 'Walk-in' }} &middot; {{ $order->created_at->format('M d, Y g:i A') }}
                </div>
                <div style="font-size:0.8rem;color:rgba(242,234,216,0.5);margin-top:0.2rem;">
                    {{ $order->orderItems->map(fn($i) => $i->menuItem->name . ' ×' . $i->quantity)->join(', ') }}
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;">
                <span style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;color:var(--caramel);">
                    ₱{{ number_format($order->total_amount, 2) }}
                </span>
                @if($order->status === 'pending')
                    <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" style="background:rgba(101,180,101,0.12);border:1px solid rgba(101,180,101,0.3);color:#8ecf8e;font-size:0.72rem;letter-spacing:0.08em;text-transform:uppercase;padding:0.4rem 0.9rem;border-radius:999px;cursor:pointer;">
                            Mark Complete ✓
                        </button>
                    </form>
                @else
                    <span style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.85rem;border-radius:999px;background:rgba(74,163,96,0.12);border:1px solid rgba(74,163,96,0.3);color:#5cb97a;">
                        Completed
                    </span>
                @endif
            </div>
        </div>
    @endforeach

    {{ $orders->links() }}

</div>
@endsection