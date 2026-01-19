<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'qr_token',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_whatsapp',
        'guest_ktp_photo',
        'payment_method',
        'proof_of_payment',
        'check_in',
        'check_out',
        'nights',
        'total_price',
        'payment_status',
        'paid_at',
        'expires_at',
        'qr_code_data',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELASI: 1 booking punya banyak item kamar
    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }
}