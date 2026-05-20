<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // A payment belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Check if payment is done
    public function isPaid()
    {
        return $this->status === 'paid';
    }
}