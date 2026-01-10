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
        // Link ke item booking yang memakai room_id (bukan uuid)
        return $this->hasMany(BookingItem::class, 'room_id', 'id');
    }

    public function activeBookingItems()
    {
        // Hanya booking yang masih berlaku (unpaid/paid)
        return $this->bookingItems()->whereHas('booking', function ($q) {
            $q->whereIn('payment_status', ['unpaid', 'paid']);
        });
    }
}