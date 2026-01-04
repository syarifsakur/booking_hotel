@extends('guest')

@section('content')
<div class="min-h-screen bg-slate-200 py-10">
    <div class="mx-auto max-w-5xl px-4">

        <!-- FORM FILTER PENCARIAN -->
<div class="rounded-md bg-white p-6 shadow-sm">
    <form method="GET" action="{{ url('/room') }}" class="grid gap-4 md:grid-cols-12 md:items-end">
        <!-- Check-in -->
        <div class="md:col-span-3">
            <label class="text-sm font-semibold text-slate-700">Check-in</label>
            <input type="date" name="check_in"
                   value="{{ request('check_in', $checkIn ?? '') }}"
                   class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400">
        </div>

        <!-- Check-out -->
        <div class="md:col-span-3">
            <label class="text-sm font-semibold text-slate-700">Check-out</label>
            <input type="date" name="check_out"
                   value="{{ request('check_out', $checkOut ?? '') }}"
                   class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400">
        </div>

        <!-- Dewasa -->
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700">Dewasa</label>
            <input type="number" min="1" name="adults"
                   value="{{ request('adults', $adults ?? 1) }}"
                   class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400">
        </div>

        <!-- Anak -->
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-slate-700">Anak</label>
            <input type="number" min="0" name="children"
                   value="{{ request('children', $children ?? 0) }}"
                   class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400">
        </div>

        <!-- Tombol cari -->
        <div class="md:col-span-2">
            <button type="submit"
                    class="w-full rounded-md bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                Cari
            </button>
        </div>
    </form>

    <p class="mt-3 text-xs text-slate-500">
        Masukkan tanggal untuk menampilkan kamar yang tersedia (tidak bentrok booking).
    </p>
</div>

 
        <!-- Filter / Summary bar -->
        <div class="mt-6 rounded-md bg-slate-300 px-6 py-4">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
             @php
    $ci = request('check_in', $checkIn ?? null);
    $co = request('check_out', $checkOut ?? null);
@endphp

<div class="text-sm font-semibold text-slate-800">
    @if($ci && $co)
        {{ \Carbon\Carbon::parse($ci)->translatedFormat('l, d M Y') }}
        —
        {{ \Carbon\Carbon::parse($co)->translatedFormat('l, d M Y') }}
        ({{ $nights ?? '-' }} Malam)
    @else
        Pilih tanggal check-in & check-out
    @endif
</div>

<div class="text-sm font-semibold text-slate-800">
    {{ request('rooms', $roomsCount ?? 1) }} Kamar,
    {{ request('adults', $adults ?? 1) }} Dewasa,
    {{ request('children', $children ?? 0) }} Anak
</div>

            </div>
        </div>

<div class="mt-8 space-y-6">

@forelse($rooms as $room)
    <div class="rounded-md bg-white p-6">
        <div class="grid gap-6 md:grid-cols-[180px_1fr_160px] md:items-center">

            <!-- Thumbnail -->
            @if($room->photo && file_exists(storage_path('app/public/' . $room->photo)))
                <div class="h-36 w-full overflow-hidden rounded">
                    <img src="{{ asset('storage/' . $room->photo) }}" 
                         alt="{{ $room->name }}" 
                         class="w-full h-full object-cover">
                </div>
            @else
                <div class="h-36 w-full overflow-hidden rounded bg-slate-200 flex items-center justify-center">
                    <span class="text-xs text-slate-500">No Image</span>
                </div>
            @endif

            <!-- Info -->
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">
                    {{ $room->name }}
                </h3>

                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                    {{ $room->description ?? '-' }}
                </p>

                <div class="mt-2 text-xs text-slate-500">
                    Tipe: {{ $room->type ?? '-' }} • Kapasitas: {{ $room->capacity }} orang
                </div>
            </div>

            <!-- Harga + Tombol -->
            <div class="flex md:flex-col items-start md:items-end justify-between gap-4">
                <div class="text-right">
                    <div class="text-xs text-slate-500">mulai dari</div>
                    <div class="text-lg font-extrabold text-slate-900">
                        Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-slate-500">/ malam</div>
                </div>

                <a href="{{ url('/room/' . $room->id) }}"
                   class="inline-flex w-full md:w-auto justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Pilih
                </a>
            </div>

        </div>
    </div>

@empty
    <!-- 🔔 JIKA KAMAR KOSONG -->
    <div class="rounded-md border border-dashed border-slate-400 bg-slate-100 p-10 text-center">
        <div class="text-lg font-bold text-slate-700">
            Kamar tidak tersedia
        </div>
        <p class="mt-2 text-sm text-slate-500">
            Silakan ubah tanggal atau jumlah tamu untuk melihat kamar lainnya.
        </p>
    </div>
@endforelse

</div>

    </div>
</div>
@endsection
