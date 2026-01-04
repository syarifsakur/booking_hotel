<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class QrController extends Controller
{
    public function show(string $token)
    {
        $booking = Booking::where('qr_token', $token)->firstOrFail();

        return view('guest.qr_show', compact('booking'));
    }
}