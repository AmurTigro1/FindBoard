<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAmenity extends Model
{
    protected $fillable = [
        'room_id',       // Foreign key to Room
        'wifi',          // Wifi
        'cabinet',       // Cabinet
        'chair',         // Chair
        'table',         // Table
        'air_conditioning',  // Air conditioning
        'electric_fan',  // Electric fan
    ];
public function room()
{
    return $this->belongsTo(Room::class);
}

}
