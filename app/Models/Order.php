<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'is_walkin',
        'total_amount',
        'discount_amount',
        'status',
    ];

    protected $casts = [
        'total_amount'    => 'float',
        'discount_amount' => 'float',
        'is_walkin'       => 'boolean',
    ];

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // An order has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Check if order is still pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Check if order is a walk-in
    public function isWalkin()
    {
        return $this->is_walkin === true;
    }

    // Get display name
    public function getDisplayNameAttribute()
    {
        return $this->user?->name ?? $this->customer_name ?? 'Walk-in Customer';
    }
}