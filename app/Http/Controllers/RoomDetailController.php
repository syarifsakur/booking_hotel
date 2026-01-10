<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

class RoomDetailController extends Controller
{
    public function show($id, Request $request)
    {
        $room = Room::where('is_active', true)->findOrFail($id);

        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        // Pilihan bulan kalender (default: bulan ini)
        $monthParam = $request->input('month');
        try {
            $startMonth = $monthParam
                ? Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth()
                : Carbon::today()->startOfMonth();
        } catch (\Exception $e) {
            $startMonth = Carbon::today()->startOfMonth();
        }

        // Ambil booking aktif (unpaid/paid) untuk room ini
        $activeItems = $room->activeBookingItems()
            ->with(['booking'])
            ->get();

        // Kumpulkan semua tanggal yang dibooking
        $bookedDates = [];
        foreach ($activeItems as $item) {
            $start = Carbon::parse($item->booking->check_in);
            $end = Carbon::parse($item->booking->check_out)->subDay();
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $bookedDates[$date->toDateString()] = true;
            }
        }

        // Bangun kalender bulan terpilih (grid minggu)
        $endMonth = $startMonth->copy()->addMonthNoOverflow()->subDay();
        $gridStart = $startMonth->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $endMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($d = $gridStart->copy(); $d->lte($gridEnd); $d->addDay()) {
            $dateStr = $d->toDateString();
            $days[] = [
                'date' => $dateStr,
                'day' => $d->day,
                'in_month' => $d->betweenIncluded($startMonth, $endMonth),
                'status' => isset($bookedDates[$dateStr]) ? 'booked' : 'available',
            ];
        }

        $calendar = [
            'monthLabel' => $startMonth->translatedFormat('F Y'),
            'monthValue' => $startMonth->format('Y-m'),
            'weeks' => array_chunk($days, 7),
        ];

        // Dropdown bulan (bulan terpilih + 5 ke depan)
        $monthOptions = [];
        for ($i = 0; $i <= 5; $i++) {
            $m = $startMonth->copy()->addMonths($i);
            $monthOptions[] = [
                'value' => $m->format('Y-m'),
                'label' => $m->translatedFormat('F Y'),
            ];
        }

        return view('guest.room_detail', [
            'room' => $room,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'calendar' => $calendar,
            'monthOptions' => $monthOptions,
        ]);
    }
}