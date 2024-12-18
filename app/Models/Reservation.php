<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'room_id', 'name', 'email', 'phone', 'address', 'visit_date', 'visit_time', 'user_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}
