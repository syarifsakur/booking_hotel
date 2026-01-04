<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomListController extends Controller
{
    public function index()
    {
        // ambil kamar dari database
        $rooms = Room::where('is_active', true)->get();

        // kirim ke blade
        return view('guest.room', compact('rooms'));
    }
}