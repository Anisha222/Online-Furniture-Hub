<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Make sure to import the Cart model here
use App\Models\Cart;
use App\Models\Order; // Assuming you have an Order model and want to use the orders() relationship
use Illuminate\Database\Eloquent\Relations\HasMany; // Make sure this is imported if not already


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Added 'is_admin' to be mass assignable
        'phone_no', // <--- CHANGED FROM 'phone' to 'phone_no'
        'address',  // <--- 'address' should be correct if your DB column is 'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Cast 'is_admin' to a boolean
        ];
    }

    /**
     * Get the cart associated with the user.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany // Added return type hint for clarity
    {
        return $this->hasMany(Order::class);
    }
}