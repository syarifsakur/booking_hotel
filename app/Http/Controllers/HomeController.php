<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRooms = [
            ['name' => 'Deluxe Room', 'desc' => 'Nyaman untuk 2 orang, AC, WiFi.', 'price' => 450000, 'badge' => 'Best Seller'],
            ['name' => 'Family Suite', 'desc' => 'Cocok untuk keluarga, ruang tamu.', 'price' => 850000, 'badge' => 'Family'],
            ['name' => 'Superior Room', 'desc' => 'Hemat tapi tetap nyaman.', 'price' => 350000, 'badge' => 'Value'],
        ];

        return view('guest.home', compact('featuredRooms'));
    }
}