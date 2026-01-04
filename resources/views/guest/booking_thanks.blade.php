@extends('layouts.app')

@section('title', 'Booking Berhasil')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Success Header -->
    <div class="text-center mb-8">
        <div class="inline-block bg-green-100 rounded-full p-4 mb-4">
            <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">✅ Booking Berhasil!</h1>
        <p class="text-gray-600">Terima kasih telah memesan kamar di Hotel Pantai Indah</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- QR Code Section (KIRI) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-center gap-2">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600">📱</span>
                    <span>QR Code Booking</span>
                </h2>

                @php
                    // QR berisi LINK ke halaman detail booking
                    $qrData = route('qr.show', ['token' => $booking->qr_token]);
                    $qrImage = null;

                    try {
                        $result = \Endroid\QrCode\Builder\Builder::create()
                            ->writer(new \Endroid\QrCode\Writer\SvgWriter()) // tidak butuh GD
                            ->data($qrData)
                            ->size(260)
                            ->margin(12)
                            ->errorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
                            ->build();

                        $qrImage = $result->getDataUri();
                    } catch (\Throwable $e) {
                        $qrImage = null;
                    }
                @endphp

                @if($qrImage)
                    <div class="bg-gray-100 rounded-xl p-5 mb-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm inline-block">
                            <img src="{{ $qrImage }}" alt="QR Code Booking" class="w-[240px] h-[240px]">
                        </div>
                    </div>
                                    <p class="text-xs text-gray-500 break-all mb-8">
                {{ $qrData }}
                </p>
                @else
                    <div class="bg-gray-100 rounded-xl p-6 mb-4 text-gray-500">
                        QR Code tidak tersedia
                    </div>
                @endif

                <p class="text-sm text-gray-600">
                    Scan QR code untuk melihat detail booking
                </p>
            </div>
        </div>

        <!-- Booking Details Section (KANAN) -->
        <div class="lg:col-span-2">
            <!-- Kode Booking -->
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-lg p-6 mb-6">
                <p class="text-green-700 text-sm font-semibold mb-2">Kode Booking Anda</p>
                <p class="text-3xl font-bold text-green-600 font-mono">{{ $booking->booking_code }}</p>
                <p class="text-green-600 text-xs mt-2">Simpan kode ini untuk konfirmasi di hotel</p>
            </div>

            <!-- Guest Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">👤 Data Tamu</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->guest_email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">WhatsApp:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->guest_phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">🏨 Detail Reservasi</h2>
                <div class="space-y-3 border-b border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Check-in:</span>
                        <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y (l)') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Check-out:</span>
                        <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y (l)') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Malam:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->nights }} malam</span>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Harga per Malam:</span>
                        <span>Rp {{ number_format($booking->total_price / $booking->nights, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Jumlah Malam:</span>
                        <span>{{ $booking->nights }} ×</span>
                    </div>
                    <div class="border-t-2 border-gray-300 pt-2 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span class="text-2xl font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Payment -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-blue-900 text-sm">
                    <strong>Status Pembayaran:</strong>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        @if($booking->payment_status === 'unpaid')
                            bg-yellow-100 text-yellow-800
                        @elseif($booking->payment_status === 'paid')
                            bg-green-100 text-green-800
                        @else
                            bg-red-100 text-red-800
                        @endif
                    ">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </p>
            </div>

            <!-- Important Info -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <h3 class="font-bold text-yellow-900 mb-2">⚠️ Informasi Penting</h3>
                <ul class="text-yellow-800 text-sm space-y-1">
                    <li>✓ Konfirmasi booking akan dikirim ke email Anda</li>
                    <li>✓ Harap tiba 30 menit sebelum waktu check-in</li>
                    <li>✓ Pembayaran dapat dilakukan di hotel atau online</li>
                    <li>✓ Pembatalan gratis hingga 24 jam sebelum check-in</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('room.list') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg text-center font-semibold transition">
                    ← Lanjut Booking
                </a>
                <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-3 rounded-lg text-center font-semibold transition">
                    🏠 Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
