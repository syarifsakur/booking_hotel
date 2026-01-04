@extends('guest')

@section('content')
<div class="min-h-screen bg-slate-200 py-10">
    <div class="mx-auto max-w-5xl px-4">

        <!-- Card -->
        <div class="rounded-md bg-white p-6 md:p-10">

            <div class="grid gap-8 md:grid-cols-2 md:items-start">

                <!-- Gambar -->
                <div class="h-64 w-full overflow-hidden rounded bg-slate-200">
                    <img
                        src="{{ asset($room['image']) }}"
                        alt="{{ $room['name'] }}"
                        class="h-full w-full object-cover"
                        onerror="this.style.display='none';"
                    >
                </div>

                <!-- Info -->
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">
                        {{ $room['name'] }}
                    </h1>

                    <p class="mt-4 text-slate-600 leading-relaxed">
                        {{ $room['desc'] }}
                    </p>

                    <!-- Fasilitas -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($room['features'] as $f)
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                {{ $f }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Harga -->
                    <div class="mt-6">
                        <div class="text-sm text-slate-500">Harga per malam</div>
                        <div class="text-2xl font-extrabold text-slate-900">
                            Rp {{ number_format($room['price'], 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Tombol Booking -->
                    <div class="mt-8 flex gap-4">
                        <a href="#"
                           class="inline-flex justify-center rounded-md bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Booking Sekarang
                        </a>

                        <a href="{{ url('/room') }}"
                           class="inline-flex justify-center rounded-md border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                            Kembali
                        </a>
                    </div>

                    @if($checkIn && $checkOut)
                        <p class="mt-4 text-xs text-slate-500">
                            Tanggal dipilih:
                            {{ $checkIn }} – {{ $checkOut }}
                        </p>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
