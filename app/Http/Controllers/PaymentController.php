<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Staff only — list all payments with filters.
     */
    public function index(Request $request)
    {
        $payments = Payment::with('order.user')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->method, fn ($q, $m) => $q->where('method', $m))
            ->latest()
            ->paginate(20);

        return view('staff.payments.index', compact('payments'));
    }

    /**
     * Staff only — view a single payment detail.
     */
    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.orderItems.menuItem');

        return view('staff.payments.show', compact('payment'));
    }

    /**
     * Staff marks a payment as paid.
     */
    public function markAsPaid(Payment $payment)
    {
        abort_unless($payment->status === 'pending', 422, 'Payment is not in a pending state.');

        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        // Also complete the order
        $payment->order->update(['status' => 'completed']);

        return back()->with('success', "Payment for Order #{$payment->order_id} marked as paid.");
    }

    /**
     * Staff marks a payment as failed (e.g. GCash declined, card rejected).
     */
    public function markAsFailed(Payment $payment)
    {
        abort_unless($payment->status === 'pending', 422, 'Only pending payments can be marked as failed.');

        $payment->update(['status' => 'failed']);

        return back()->with('success', "Payment for Order #{$payment->order_id} marked as failed.");
    }
}