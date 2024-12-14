<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'captcha',
        'phone',
        'address',
        'password',
        'subscription_active', 
        'trial_ends_at',
        'business_permit', 'business_permit_status'
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
    protected $casts = [
        'trial_ends_at' => 'datetime',
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
        ];
    }

    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
    public function boardingHouse()
    {
        return $this->hasOne(BoardingHouse::class, 'user_id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function hasVerifiedPhoto()
    {
        return !is_null($this->profile_photo_path); // Adjust according to your logic
    }
    
    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at); // Adjust according to your logic
    }
    public function hasVerifiedBusinessPermit()
{
    return !is_null($this->business_permit_path);
}
public function reservations()
{
    return $this->hasMany(Reservation::class);
}
public function subscription()
{
    return $this->hasOne(Subscription::class);
}
}
