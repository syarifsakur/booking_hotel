<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomDetailController extends Controller
{
    public function show($id, Request $request)
    {
        // Ambil kamar dari database
        $room = Room::findOrFail($id);
        
        return view('guest.room_detail', ['room' => $room]);

        if (!isset($rooms[$id])) {
            abort(404);
        }

        $room = $rooms[$id];

        // Ambil query tanggal jika ada (dari halaman list)
        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        return view('guest.room-detail', compact('room', 'checkIn', 'checkOut'));
    }
}