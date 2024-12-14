<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'bathrooms',
        'wifi',
        'refrigerator',
        'electric_bill',
        'water_bill',
        'cctv',
        'kitchen',
        'laundry_service',
    ];
    
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
    public function rooms()
{
    return $this->belongsToMany(Room::class, 'room_amenity', 'amenity_id', 'room_id');
}

}