<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardingHouse extends Model
{
    // protected $fillable = [
    //     'user_id',
    //     'name',
    //     'address',
    //     'latitude', 
    //     'longitude', 
    //     'image', 
    //     // 'landlord_id',
    //     'monthly',
    //     'rating', 
    //     'reviews_count',
    //     'availability', 'availability_date', 'policy',
    // ];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Replace 'user_id' with the actual foreign key column name
    }
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    public function isInWishlist($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }
    
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    

    // public function landlord()
    // {
    //     return $this->belongsTo(User::class, 'landlord_id');
    // }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function amenities()
    {
        return $this->hasOne(Amenity::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

     public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }


}
