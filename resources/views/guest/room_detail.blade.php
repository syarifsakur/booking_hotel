@extends('layouts.app')

@section('title', 'Detail Kamar - ' . $room->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('room.list') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar Kamar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Foto Kamar -->
        <div class="md:col-span-2">
            @if($room->photo && file_exists(storage_path('app/public/' . $room->photo)))
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img 
                        src="{{ asset('storage/' . $room->photo) }}" 
                        alt="{{ $room->name }}" 
                        class="w-full h-96 object-cover"
                    >
                </div>
            @else
                <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-gray-500 text-lg">📷 Foto tidak tersedia</p>
                    </div>
                </div>
            @endif

            <!-- Info Kamar -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Deskripsi Kamar</h2>
                @if($room->description)
                    <p class="text-gray-700 leading-relaxed">{{ $room->description }}</p>
                @else
                    <p class="text-gray-500">Tidak ada deskripsi</p>
                @endif
            </div>

            <!-- Fasilitas (Optional) -->
            <div class="mt-6 bg-blue-50 rounded-lg border border-blue-200 p-6">
                <h3 class="font-semibold text-blue-900 mb-4">✨ Fasilitas</h3>
                <ul class="grid grid-cols-2 gap-4 text-blue-800 text-sm">
                    <li>✓ AC</li>
                    <li>✓ WiFi Gratis</li>
                    <li>✓ TV Flat</li>
                    <li>✓ Kamar Mandi Bersih</li>
                    <li>✓ Tempat Tidur Nyaman</li>
                    <li>✓ Towel Gratis</li>
                </ul>
            </div>
        </div>

        <!-- Info Booking -->
        <div>
            <!-- Card Info Kamar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                <!-- Nama & Tipe -->
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $room->name }}</h1>
                <div class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $room->type }}
                </div>

                <!-- Harga -->
                <div class="mb-6 border-b border-gray-200 pb-6">
                    <p class="text-gray-600 text-sm mb-2">Harga Per Malam</p>
                    <p class="text-3xl font-bold text-green-600">
                        Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Kapasitas -->
                <div class="mb-6 flex items-center gap-4">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm">Kapasitas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $room->capacity }} Orang</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>

                <!-- Status -->
                @if($room->is_active)
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-green-800 text-sm font-semibold">✅ Kamar Tersedia</p>
                    </div>
                @else
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-3">
                        <p class="text-red-800 text-sm font-semibold">❌ Kamar Tidak Tersedia</p>
                    </div>
                @endif

                <!-- Tombol Booking -->
                @if($room->is_active)
                    <a 
                        href="{{ route('guest.booking.create', $room->id) }}"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2"
                    >
                        📅 Pesan Kamar
                    </a>
                @else
                    <button 
                        disabled
                        class="w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed"
                    >
                        ❌ Tidak Tersedia
                    </button>
                @endif
            </div>

            <!-- Info Tambahan -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-900 mb-2">💡 Tips</h3>
                <ul class="text-yellow-800 text-sm space-y-1">
                    <li>✓ Harga per malam</li>
                    <li>✓ Pajak sudah termasuk</li>
                    <li>✓ Gratis pembatalan 24 jam</li>
                    <li>✓ Check-in 14:00, Check-out 12:00</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Review / Testimoni -->
    <div class="mt-12 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ Ulasan Tamu</h2>
        <div class="space-y-4">
            <div class="border-b border-gray-200 pb-4">
                <div class="flex items-center gap-2 mb-2">
                    <p class="font-semibold text-gray-800">Rina Wijaya</p>
                    <div class="text-yellow-400">★★★★★</div>
                </div>
                <p class="text-gray-600">Kamar yang sangat nyaman dan bersih. Pelayanan ramah. Pasti akan menginap lagi!</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <div class="flex items-center gap-2 mb-2">
                    <p class="font-semibold text-gray-800">Ahmad Pratama</p>
                    <div class="text-yellow-400">★★★★</div>
                </div>
                <p class="text-gray-600">Lokasi bagus, fasilitas lengkap. Hanya sarannya AC bisa lebih dingin.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky {
        position: sticky;
    }
</style>
@endsection
