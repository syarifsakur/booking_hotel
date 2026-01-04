<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'type',
        'price_per_night',
        'capacity',
        'description',
        'photo',
        'is_active',
    ];

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class, 'room_uuid', 'uuid');
    }
}