@extends('guest')


@section('content')

    <section class="bg-slate-900 text-white">
                <h1 class="pt-5 text-2xl font-extrabold tracking-tight md:text-4xl flex justify-center">
                    Hotel Pantai Indah
                </h1>
        <div class="mx-auto max-w-6xl px-4 py-14 md:py-20 grid gap-10 md:grid-cols-2 items-center">
            <div>
                <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Booking cepat • QR untuk check-in
                </p>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight md:text-5xl">
                    Booking kamar hotel tanpa ribet.
                </h1>

                <p class="mt-4 text-slate-200 md:text-lg">
                    Pilih tanggal, pilih kamar, dapatkan QR Code. Saat check-in tinggal scan.
                </p>

                <div class="mt-7 flex gap-3">
                    <a href="/room" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">
                        Lihat Kamar
                    </a>

                </div>
            </div>

            <div id="cek" class="rounded-3xl bg-white p-6 shadow-xl text-slate-900 md:p-8">
                <h2 class="text-lg font-bold">Cek ketersediaan</h2>
                <p class="mt-1 text-sm text-slate-600">Masukkan tanggal menginap.</p>

                <form class="mt-6 grid gap-4" method="GET" action="#">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium">Check-in</label>
                            <input type="date" name="check_in"
                                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-slate-400">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Check-out</label>
                            <input type="date" name="check_out"
                                   class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-slate-400">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                        Cari Kamar
                    </button>

                    <div class="rounded-2xl bg-slate-50 p-4 text-xs text-slate-600">
                        Setelah booking berhasil, kamu akan dapat <b>QR Code</b> untuk check-in.
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- <div class="min-h-screen py-10">
        <div class="mx-auto max-w-5xl px-4">

            <!-- Top bar -->
            <div class="h-14 w-full rounded-md bg-slate-300"></div>

            <!-- HERO CARD -->
            <div class="mt-8 rounded-md bg-white px-6 py-14 md:px-10">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight md:text-5xl">
                        Hotel Pantai Indah
                    </h1>

                    <!-- garis panjang -->
                    <div class="mx-auto mt-6 h-3 w-[70%] rounded bg-slate-200"></div>

                    <!-- 2 tombol abu-abu -->
                    <div class="mx-auto mt-6 flex max-w-md justify-center gap-6">
                        <div class="h-10 w-40 rounded bg-slate-200"></div>
                        <div class="h-10 w-40 rounded bg-slate-200"></div>
                    </div>
                </div>
            </div>

            <!-- CONTENT CARD (kiri teks, kanan gambar) -->
            <div class="mt-10 rounded-md bg-white p-6 md:p-10">
                <div class="grid gap-10 md:grid-cols-2 md:items-center">
                    <!-- kiri: teks placeholder -->
                    <div class="space-y-4">
                        <div class="h-4 w-[85%] rounded bg-slate-200"></div>
                        <div class="h-4 w-[78%] rounded bg-slate-200"></div>
                        <div class="h-4 w-[70%] rounded bg-slate-200"></div>

                        <div class="h-10 w-[55%] rounded bg-slate-200 mt-6"></div>

                        <div class="h-4 w-[60%] rounded bg-slate-200 mt-6"></div>
                        <div class="h-4 w-[90%] rounded bg-slate-200"></div>

                        <div class="h-4 w-[65%] rounded bg-slate-200 mt-6"></div>
                        <div class="h-4 w-[88%] rounded bg-slate-200"></div>
                    </div>

                    <!-- kanan: box gambar -->
                    <div class="mx-auto h-60 w-full max-w-md rounded bg-slate-200 md:h-64"></div>
                </div>
            </div>

            <!-- Footer bar -->
            <div class="mt-10 h-20 w-full rounded-md bg-slate-300"></div>
        </div>
    </div> --}}
@endsection
