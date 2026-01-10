@extends('guest')

@section('title', 'Detail Booking')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Booking</h1>

        <div class="space-y-2 text-sm">
            <div><b>Kode Booking:</b> {{ $booking->booking_code }}</div>
            <div><b>Nama:</b> {{ $booking->guest_name }}</div>
            <div><b>Email:</b> {{ $booking->guest_email ?? '-' }}</div>
            <div><b>Phone:</b> {{ $booking->guest_phone ?? '-' }}</div>
            <div><b>Check-in:</b> {{ $booking->check_in }}</div>
            <div><b>Check-out:</b> {{ $booking->check_out }}</div>
            <div><b>Malam:</b> {{ $booking->nights }}</div>
            <div><b>Total:</b> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
            <div><b>Status:</b> {{ ucfirst($booking->payment_status) }}</div>
        </div>
    </div>
</div>
@endsection
