@extends('guest')

@section('title', 'Home - Hotel Booking')

@section('content')
    <section class="bg-slate-900 text-white">
        <div class="mx-auto max-w-6xl px-3 md:px-4 py-8 md:py-14 lg:py-20 grid gap-6 md:gap-10 md:grid-cols-2 items-center">
            <div>
                <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs md:text-sm font-semibold">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Booking cepat • QR untuk check-in
                </p>

                <h1 class="mt-3 md:mt-5 text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-tight">
                    Booking kamar hotel tanpa ribet.
                </h1>

                <p class="mt-3 md:mt-4 text-slate-200 text-sm md:text-base lg:text-lg">
                    Pilih tanggal, pilih kamar, dapatkan QR Code. Saat check-in tinggal scan.
                </p>

                <div class="mt-5 md:mt-7 flex flex-col sm:flex-row gap-3">
                    <a href="#cek" class="rounded-xl bg-white px-4 md:px-5 py-2 md:py-3 text-sm md:text-base font-semibold text-slate-900 hover:bg-slate-100 text-center">
                        Cek Ketersediaan
                    </a>
                    <a href="#kamar" class="rounded-xl border border-white/30 px-4 md:px-5 py-2 md:py-3 text-sm md:text-base font-semibold text-white hover:bg-white/10 text-center">
                        Lihat Kamar
                    </a>
                </div>
            </div>

            <div id="cek" class="rounded-2xl md:rounded-3xl bg-white p-4 md:p-6 lg:p-8 shadow-xl text-slate-900">
                <h2 class="text-base md:text-lg font-bold">Cek ketersediaan</h2>
                <p class="mt-1 text-xs md:text-sm text-slate-600">Masukkan tanggal menginap.</p>

                <form class="mt-4 md:mt-6 grid gap-3 md:gap-4" method="GET" action="#">
                    <div class="grid gap-3 md:gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-xs md:text-sm font-medium">Check-in</label>
                            <input type="date" name="check_in"
                                   class="mt-1 w-full rounded-lg md:rounded-xl border border-slate-200 px-2 md:px-3 py-2 text-xs md:text-sm outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
                        </div>
                        <div>
                            <label class="text-xs md:text-sm font-medium">Check-out</label>
                            <input type="date" name="check_out"
                                   class="mt-1 w-full rounded-lg md:rounded-xl border border-slate-200 px-2 md:px-3 py-2 text-xs md:text-sm outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg md:rounded-xl bg-slate-900 px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold text-white hover:bg-slate-800">
                        Cari Kamar
                    </button>

                    <div class="rounded-lg md:rounded-2xl bg-slate-50 p-3 md:p-4 text-xs text-slate-600">
                        Setelah booking berhasil, kamu akan dapat <b>QR Code</b> untuk check-in.
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="kamar" class="mx-auto max-w-6xl px-3 md:px-4 py-8 md:py-14">
        <h2 class="text-xl md:text-2xl font-extrabold">Kamar favorit</h2>
        <p class="mt-1 text-xs md:text-sm text-slate-600">Pilihan yang sering dipesan.</p>

        <div class="mt-6 md:mt-8 grid gap-4 md:gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredRooms as $room)
                <div class="rounded-2xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between gap-2">
                        <span class="rounded-full bg-slate-100 px-2 md:px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ $room['badge'] }}
                        </span>
                        <span class="text-xs text-slate-500">per malam</span>
                    </div>

                    <h3 class="mt-3 md:mt-4 text-base md:text-lg font-bold">{{ $room['name'] }}</h3>
                    <p class="mt-2 text-xs md:text-sm text-slate-600">{{ $room['desc'] }}</p>

                    <div class="mt-4 md:mt-5 flex items-center justify-between gap-2">
                        <div class="text-base md:text-lg font-extrabold">
                            Rp {{ number_format($room['price'], 0, ',', '.') }}
                        </div>
                        <a href="#cek" class="rounded-lg md:rounded-xl bg-slate-900 px-3 md:px-4 py-2 text-xs md:text-sm font-semibold text-white hover:bg-slate-800">
                            Pilih
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
