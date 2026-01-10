<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomListController extends Controller
{
    public function index(Request $request)
    {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        $query = Room::where('is_active', true);

        // Filter berdasarkan ketersediaan tanggal (hindari bentrok booking)
        if ($checkIn && $checkOut) {
            $query->whereDoesntHave('bookingItems', function ($q) use ($checkIn, $checkOut) {
                $q->whereHas('booking', function ($qb) use ($checkIn, $checkOut) {
                    $qb->whereIn('payment_status', ['unpaid', 'paid'])
                       ->where('check_in', '<', $checkOut)
                       ->where('check_out', '>', $checkIn);
                });
            });
        }

        $rooms = $query->get();

        $nights = null;
        if ($checkIn && $checkOut) {
            $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        }

        $roomsCount = $rooms->count();

        // kirim ke blade beserta info filter
        return view('guest.room', [
            'rooms' => $rooms,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'roomsCount' => $roomsCount,
        ]);
    }
}