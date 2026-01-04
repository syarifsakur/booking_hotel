<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalRooms'    => Room::count(),
            'totalBookings' => Booking::count(),
            'totalUsers'    => User::count(),
            'recentBookings'=> Booking::latest()->take(5)->get(),
            'rooms'         => Room::latest()->take(8)->get(),
        ]);
    }

    public function rooms()
    {
        return view('admin.rooms.index', [
            'rooms' => Room::paginate(10),
        ]);
    }

    public function bookings()
    {
        return view('admin.bookings.index', [
            'bookings' => Booking::with('user')->paginate(10),
        ]);
    }

    public function users()
    {
        return view('admin.users.index', [
            'users' => User::paginate(10),
        ]);
    }

    public function createRoom()
    {
        return view('admin.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|unique:rooms,name|max:50',
            'type'            => 'required|string|max:50',
            'price_per_night' => 'required|numeric|min:0',
            'capacity'        => 'required|integer|min:1|max:10',
            'description'     => 'nullable|string|max:1000',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'       => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/rooms', $filename);
            $validated['photo'] = 'rooms/' . $filename;
        }

        Room::create($validated);

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }
}