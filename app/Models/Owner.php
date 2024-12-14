<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
}
