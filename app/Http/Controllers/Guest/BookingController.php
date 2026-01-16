<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Room $room)
    {
        if (!$room->is_active) {
            abort(404);
        }

        return view('guest.booking_create', ['room' => $room]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guest_ktp_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'proof_of_payment' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $room = Room::findOrFail($data['room_id']);

        if (!$room->is_active) {
            return back()->withErrors(['room_id' => 'Kamar tidak tersedia untuk dipesan.'])->withInput();
        }

        $checkIn = Carbon::parse($data['check_in'])->startOfDay();
        $checkOut = Carbon::parse($data['check_out'])->startOfDay();
        $nights = $checkIn->diffInDays($checkOut);
        if ($nights <= 0) {
            return back()->withErrors(['check_out' => 'Tanggal check-out harus setelah check-in.'])->withInput();
        }

        // Cek bentrok booking lain (unpaid/paid dianggap menahan kamar)
        $isBooked = BookingItem::where('room_id', $room->id)
            ->whereHas('booking', function ($q) use ($checkIn, $checkOut) {
                $q->whereIn('payment_status', ['unpaid', 'paid'])
                  ->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn);
            })
            ->exists();

        if ($isBooked) {
            return back()
                ->withErrors(['check_in' => 'Kamar sudah dibooking pada rentang tanggal tersebut.'])
                ->withInput();
        }

        $qty = 1; // satu kamar hanya boleh satu booking per rentang tanggal
        $ktpPath = $request->hasFile('guest_ktp_photo')
            ? $request->file('guest_ktp_photo')->store('booking-ktp', 'public')
            : null;
        $paymentProofPath = $request->hasFile('proof_of_payment')
            ? $request->file('proof_of_payment')->store('booking-payment', 'public')
            : null;

        $subtotal = $room->price_per_night * $nights * $qty;

        $booking = DB::transaction(function () use ($data, $room, $nights, $subtotal, $qty, $ktpPath, $paymentProofPath) {
            $booking = Booking::create([
                'booking_code' => $this->generateBookingCode(),
                'qr_token' => Str::uuid()->toString(),
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'guest_ktp_photo' => $ktpPath,
                'proof_of_payment' => $paymentProofPath,
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'nights' => $nights,
                'total_price' => $subtotal,
                'payment_status' => 'unpaid',
                'status' => 'tidak_aktif',
                'expires_at' => now()->addDay(),
            ]);

            BookingItem::create([
                'booking_id' => $booking->id,
                'room_id' => $room->id,
                'price_per_night' => $room->price_per_night,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ]);

            // Simpan payload QR untuk referensi
            $booking->qr_code_data = json_encode([
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
            $booking->save();

            return $booking;
        });

        return redirect()->route('guest.booking.thanks', $booking->id);
    }

    private function generateBookingCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    public function thanks(Booking $booking)
    {
        return view('guest.booking_thanks', ['booking' => $booking]);
    }
}