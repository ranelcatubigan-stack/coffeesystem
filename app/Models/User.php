<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // A user can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Check if user is staff
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    // Check if user is customer
    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}