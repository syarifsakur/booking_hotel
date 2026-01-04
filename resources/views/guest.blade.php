<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hotel Pantai Indah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script src="https://cdn.tailwindcss.com"></script>
<body class="bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-40 border-b bg-gradient-to-r from-white/60 to-white/40 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 font-semibold">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow">H</span>
                <div class="leading-tight">
                    <div class="text-sm">Hotel Pantai Indah</div>
                    <div class="text-xs text-slate-500">Booking cepat & mudah</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="/" class="hover:text-slate-700">Dashboard</a>
                <a href="/room" class="hover:text-slate-700">Kamar</a>
                <a href="/about" class="hover:text-slate-700">Tentang</a>
            </nav>

            {{-- <div class="flex items-center gap-3">
                <div class="hidden md:block">
                    <form action="#" method="GET" class="flex items-center gap-2">
                        <input type="search" name="q" placeholder="Cari lokasi atau hotel"
                               class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none w-56 focus:ring-1 focus:ring-emerald-400">
                    </form>
                </div> --}}

                <a href="/login" class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600">
                    Admin Panel
                </a>

                <button class="md:hidden rounded-lg p-2 text-slate-700 hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 border-t bg-white">
        <div class="mx-auto max-w-6xl px-4 py-12 text-sm text-slate-600 grid gap-6 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-3 font-semibold mb-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500 text-white">H</span>
                    <div>HotePantaiIndah</div>
                </div>
                <div>Booking cepat, dapatkan QR untuk check-in tanpa ribet.</div>
            </div>

            <div>
                <div class="font-medium mb-2">Tautan</div>
                <ul class="space-y-2">
                    <li><a href="#kamar" class="hover:text-slate-800">Kamar</a></li>
                    <li><a href="#fasilitas" class="hover:text-slate-800">Fasilitas</a></li>
                    <li><a href="#cek" class="hover:text-slate-800">Cek Tanggal</a></li>
                </ul>
            </div>

            <div>
                <div class="font-medium mb-2">Hubungi Kami</div>
                <div class="text-slate-500">support@hotelpantaiindah.example</div>
                <div class="mt-4 flex items-center gap-3">
                    <a class="p-2 rounded-full bg-slate-100 text-slate-700" href="#">Twitter</a>
                    <a class="p-2 rounded-full bg-slate-100 text-slate-700" href="#">Instagram</a>
                </div>
            </div>
        </div>

        <div class="border-t bg-slate-50">
            <div class="mx-auto max-w-6xl px-4 py-6 text-xs text-slate-500 flex justify-center">© {{ date('Y') }} Hotel Pantai Indah. All rights reserved.</div>
        </div>
    </footer>
</body>
</html>
