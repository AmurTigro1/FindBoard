<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_name', 'max_boarding_houses', 'max_rooms', 'start_date', 'end_date', 'amount_paid', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
