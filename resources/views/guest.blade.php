<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', 'Booking kamar hotel dengan mudah dan cepat. Temukan kamar terbaik untuk liburan Anda.')">
    <meta name="keywords" content="hotel, booking, kamar hotel, penginapan, akomodasi">
    <meta name="author" content="Hotel Pantai Indah">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Hotel Pantai Indah')">
    <meta property="og:description" content="@yield('description', 'Booking kamar hotel dengan mudah dan cepat')">
    <meta property="og:image" content="@yield('og_image', asset('images/hotel-default.jpg'))">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Hotel Pantai Indah')">
    <meta property="twitter:description" content="@yield('description', 'Booking kamar hotel dengan mudah dan cepat')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/hotel-default.jpg'))">
    
    <title>@yield('title', 'Hotel Pantai Indah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script src="https://cdn.tailwindcss.com"></script>
<body class="bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-40 border-b bg-gradient-to-r from-white/60 to-white/40 backdrop-blur">
        <div class="mx-auto max-w-6xl px-3 md:px-4 py-3 md:py-4 flex items-center justify-between gap-3 md:gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 md:gap-3 font-semibold">
                <span class="inline-flex h-8 md:h-10 w-8 md:w-10 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow text-sm md:text-base">H</span>
                <div class="leading-tight hidden sm:block">
                    <div class="text-xs md:text-sm">Hotel Pantai Indah</div>
                    <div class="text-xs text-slate-500">Booking cepat & mudah</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-4 md:gap-6 text-xs md:text-sm">
                <a href="/" class="hover:text-slate-700">Dashboard</a>
                <a href="/room" class="hover:text-slate-700">Kamar</a>
                <a href="/about" class="hover:text-slate-700">Tentang</a>
            </nav>

            <a href="/login" class="hidden sm:inline-flex items-center gap-1 md:gap-2 rounded-xl bg-emerald-500 px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-semibold text-white shadow hover:bg-emerald-600">
                Admin Panel
            </a>

            <button class="md:hidden rounded-lg p-2 text-slate-700 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 md:h-6 w-5 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-12 md:mt-16 border-t bg-white">
        <div class="mx-auto max-w-6xl px-3 md:px-4 py-8 md:py-12 text-xs md:text-sm text-slate-600 grid gap-4 md:gap-6 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-2 md:gap-3 font-semibold mb-2">
                    <span class="inline-flex h-8 md:h-9 w-8 md:w-9 items-center justify-center rounded-xl bg-emerald-500 text-white text-xs md:text-sm">H</span>
                    <div>HotePantaiIndah</div>
                </div>
                <div>Booking cepat, dapatkan QR untuk check-in tanpa ribet.</div>
            </div>

            <div>
                <div class="font-medium mb-2">Tautan</div>
                <ul class="space-y-1 md:space-y-2">
                    <li><a href="#kamar" class="hover:text-slate-800">Kamar</a></li>
                    <li><a href="#fasilitas" class="hover:text-slate-800">Fasilitas</a></li>
                    <li><a href="#cek" class="hover:text-slate-800">Cek Tanggal</a></li>
                </ul>
            </div>

            <div>
                <div class="font-medium mb-2">Hubungi Kami</div>
                <div class="text-slate-500">support@hotelpantaiindah.example</div>
                <div class="mt-3 md:mt-4 flex items-center gap-2 md:gap-3">
                    <a class="p-2 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs md:text-sm" href="#">Twitter</a>
                    <a class="p-2 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs md:text-sm" href="#">Instagram</a>
                </div>
            </div>
        </div>

        <div class="border-t bg-slate-50">
            <div class="mx-auto max-w-6xl px-3 md:px-4 py-4 md:py-6 text-xs text-slate-500 flex justify-center">
                © {{ date('Y') }} Hotel Pantai Indah. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
