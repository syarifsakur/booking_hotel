@extends('guest')

@section('content')
<div class="min-h-screen bg-slate-200 py-6 md:py-10">
    <div class="mx-auto max-w-5xl px-3 md:px-4">
        <div class="mt-4 md:mt-6 rounded-lg md:rounded-md bg-slate-300 px-3 md:px-6 py-3 md:py-4">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                @php
                    $ci = request('check_in', $checkIn ?? null);
                    $co = request('check_out', $checkOut ?? null);
                @endphp

                <div class="text-xs md:text-sm font-semibold text-slate-800">
                    @if($ci && $co)
                        {{ \Carbon\Carbon::parse($ci)->translatedFormat('l, d M Y') }}
                        —
                        {{ \Carbon\Carbon::parse($co)->translatedFormat('l, d M Y') }}
                        ({{ $nights ?? '-' }} Malam)
                    @else
                        Pilih Kamar Anda
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 md:mt-8 grid gap-4 md:gap-6 sm:grid-cols-2 lg:grid-cols-2">
            @forelse($rooms as $room)
                <div class="group rounded-lg md:rounded-xl bg-white shadow-md border border-slate-100 overflow-hidden flex flex-col transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative h-40 md:h-48 w-full overflow-hidden bg-slate-100">
                        @if($room->photo)
                            <img src="{{ asset('storage/' . $room->photo) }}"
                                 alt="{{ $room->name }} - {{ $room->type }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-400">
                                <svg class="w-10 h-10 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute left-2 md:left-4 top-2 md:top-4 inline-flex items-center gap-2 rounded-full bg-white/80 px-2 md:px-3 py-1 text-xs font-semibold text-slate-700 shadow">
                            <span>{{ $room->type ?? 'Kamar' }}</span>
                            <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col gap-2 md:gap-3 p-3 md:p-5">
                        <div class="flex items-start justify-between gap-2 md:gap-3">
                            <div class="flex-1">
                                <h3 class="text-sm md:text-lg font-bold text-slate-900">{{ $room->name }}</h3>
                                <p class="mt-1 text-xs md:text-sm text-slate-600 line-clamp-2">{{ $room->description ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <p class="text-[10px] md:text-[11px] uppercase tracking-wide text-slate-400">Mulai</p>
                                <p class="text-base md:text-xl font-extrabold text-slate-900">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-500">/ malam</p>
                            </div>
                        </div>

                        <div class="flex flex-col xs:flex-row items-start xs:items-center gap-2 text-xs text-slate-600">
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 md:px-3 py-1 whitespace-nowrap">
                                👥 Kapasitas {{ $room->capacity }} orang
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 md:px-3 py-1 whitespace-nowrap">
                                🛏️ Tipe {{ $room->type ?? '-' }}
                            </span>
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-2 md:gap-3 pt-2">
                            <a href="{{ url('/room/' . $room->id) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 px-3 md:px-4 py-2 text-xs md:text-sm font-semibold text-white transition hover:bg-slate-800">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="rounded-lg border border-dashed border-slate-400 bg-slate-100 p-6 md:p-10 text-center sm:col-span-2">
                    <div class="text-base md:text-lg font-bold text-slate-700">
                        Kamar tidak tersedia
                    </div>
                    <p class="mt-2 text-xs md:text-sm text-slate-500">
                        Silakan ubah tanggal atau jumlah tamu untuk melihat kamar lainnya.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
