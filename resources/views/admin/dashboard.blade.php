@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Kelola hotel, kamar, dan booking dengan mudah')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-xs md:text-sm">Total Kamar</p>
                <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalRooms }}</p>
            </div>
            <div class="bg-blue-100 p-2 md:p-3 rounded-lg">
                <span class="text-lg md:text-2xl">🛏️</span>
            </div>
        </div>
        <a href="{{ route('admin.rooms') }}" class="text-blue-500 text-xs md:text-sm mt-3 inline-block hover:underline">
            Lihat semua kamar →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-xs md:text-sm">Total Booking</p>
                <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalBookings }}</p>
            </div>
            <div class="bg-green-100 p-2 md:p-3 rounded-lg">
                <span class="text-lg md:text-2xl">📋</span>
            </div>
        </div>
        <a href="{{ route('admin.bookings') }}" class="text-green-500 text-xs md:text-sm mt-3 inline-block hover:underline">
            Lihat semua booking →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-xs md:text-sm">Total User</p>
                <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
            </div>
            <div class="bg-purple-100 p-2 md:p-3 rounded-lg">
                <span class="text-lg md:text-2xl">👥</span>
            </div>
        </div>
        <a href="{{ route('admin.users') }}" class="text-purple-500 text-xs md:text-sm mt-3 inline-block hover:underline">
            Lihat semua user →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-xs md:text-sm">Info Cepat</p>
                <p class="text-sm font-semibold text-slate-900 mt-2">
                    Semuanya berjalan normal ✓
                </p>
            </div>
            <div class="bg-yellow-100 p-2 md:p-3 rounded-lg">
                <span class="text-lg md:text-2xl">⚡</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow">
            <div class="px-4 md:px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h2 class="text-base md:text-lg font-bold text-slate-900">📅 Booking Terbaru</h2>
                <a href="{{ route('admin.bookings') }}" class="text-blue-500 text-xs md:text-sm hover:underline">
                    Lihat semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs md:text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Tamu</th>
                            <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Email</th>
                            <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Tanggal</th>
                            <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr class="border-b border-slate-200 hover:bg-slate-50">
                                <td class="px-3 md:px-6 py-4 text-slate-900">
                                    {{ $booking->guest_name ?? 'N/A' }}
                                </td>
                                <td class="px-3 md:px-6 py-4 text-slate-600 truncate">
                                    {{ $booking->guest_email ?? 'N/A' }}
                                </td>
                                <td class="px-3 md:px-6 py-4 text-slate-600">
                                    {{ $booking->created_at->format('d M Y') }}
                                </td>
                                <td class="px-3 md:px-6 py-4">
                                    <span class="inline-block px-2 md:px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        Aktif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 md:px-6 py-4 text-center text-slate-500">
                                    Belum ada booking
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 md:p-6">
        <h2 class="text-base md:text-lg font-bold text-slate-900 mb-4">⚙️ Menu Cepat</h2>
        
        <div class="space-y-2 md:space-y-3">
            <a href="{{ route('admin.rooms') }}" class="block px-3 md:px-4 py-2 md:py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-semibold transition text-sm md:text-base">
                🛏️ Kelola Kamar
            </a>

            <a href="{{ route('admin.bookings') }}" class="block px-3 md:px-4 py-2 md:py-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg font-semibold transition text-sm md:text-base">
                📋 Kelola Booking
            </a>

            <a href="{{ route('admin.users') }}" class="block px-3 md:px-4 py-2 md:py-3 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-semibold transition text-sm md:text-base">
                👥 Kelola User
            </a>
        </div>
    </div>

</div>
@endsection

