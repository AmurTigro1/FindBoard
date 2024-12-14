<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'boarding_house_id', 
        'type', 
        'description', 
        'price', 
        'wifi', 
        'occupancy', 
        'refrigerator', 
        'curfew', 
        'amenities', 
        'thumbnail_image', 
        'main_images',
        'number_of_beds'

    ];
    // protected $casts = [
    //     'main_images' => 'array', // Automatically decode JSON to array
    //     'amenities' => 'array',
    // ];
    
    public function images()
{
    return $this->hasMany(Image::class);
}

    public function boardingHouse()
    {
        // return $this->belongsTo(BoardingHouse::class);
        return $this->belongsTo(BoardingHouse::class, 'boarding_house_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity', 'room_id', 'amenity_id');
    }

    public function roomAmenity()
    {
        return $this->hasMany(RoomAmenity::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function isInWishlist($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }
}
