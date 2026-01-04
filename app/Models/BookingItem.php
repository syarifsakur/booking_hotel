<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $fillable = [
        'booking_id',
        'room_id',
        'price_per_night',
        'qty',
        'subtotal',
    ];

    // RELASI: item ini milik satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // RELASI: item ini milik satu kamar
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}