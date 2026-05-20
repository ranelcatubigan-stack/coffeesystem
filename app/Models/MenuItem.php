<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price'        => 'float',
    ];

    // A menu item can appear in many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scope: only available items (for customers)
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope: filter by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}