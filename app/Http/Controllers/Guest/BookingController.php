<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingItem;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class BookingController extends Controller
{
    public function create(Room $room)
    {
        return view('guest.booking_create', ['room' => $room]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'nullable|string|max:50',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'qty' => 'nullable|integer|min:1',
        ]);

        $room = Room::findOrFail($data['room_id']);

        $nights = (new \DateTime($data['check_in']))->diff(new \DateTime($data['check_out']))->days;
        $qty = $data['qty'] ?? 1;

        $subtotal = $room->price_per_night * $nights * $qty;

        $booking = Booking::create([
            'booking_code' => strtoupper(Str::random(8)),
            'qr_token' => Str::uuid()->toString(),
            'guest_name' => $data['guest_name'],
            'guest_email' => $data['guest_email'] ?? null,
            'guest_phone' => $data['guest_phone'] ?? null,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'nights' => $nights,
            'total_price' => $subtotal,
            'payment_status' => 'unpaid',
            'expires_at' => now()->addDay(),
        ]);

        BookingItem::create([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'price_per_night' => $room->price_per_night,
            'qty' => $qty,
            'subtotal' => $subtotal,
        ]);

        // Generate QR code dengan data booking
        $qrData = json_encode([
            'booking_code' => $booking->booking_code,
            'guest_name' => $booking->guest_name,
            'guest_email' => $booking->guest_email,
            'guest_phone' => $booking->guest_phone,
            'room_name' => $room->name,
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'nights' => $booking->nights,
            'total_price' => $booking->total_price,
            'payment_status' => $booking->payment_status,
        ]);
        
        $booking->qr_code_data = $qrData;
        $booking->save();

        return redirect()->route('guest.booking.thanks', $booking->id);
    }

    public function thanks(Booking $booking)
    {
        return view('guest.booking_thanks', ['booking' => $booking]);
    }
}