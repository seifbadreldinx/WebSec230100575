<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'credit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role that the user belongs to.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    /**
     * Check if user is a customer.
     */
    public function isCustomer()
    {
        return $this->hasRole('Customer');
    }

    /**
     * Check if user is an employee.
     */
    public function isEmployee()
    {
        return $this->hasRole('Employee');
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the bought products for the user.
     */
    public function boughtProducts()
    {
        return $this->hasMany(BoughtProduct::class);
    }

    /**
     * Check if user has enough credit to buy a product.
     */
    public function hasEnoughCredit($amount)
    {
        return $this->credit >= $amount;
    }

    /**
     * Deduct credit from user account.
     */
    public function deductCredit($amount)
    {
        $this->credit -= $amount;
        $this->save();
    }

    /**
     * Add credit to user account.
     */
    public function addCredit($amount)
    {
        $this->credit += $amount;
        $this->save();
    }
}
