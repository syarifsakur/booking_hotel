<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Booking System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500 text-white font-bold">
                    H
                </div>
                <div>
                    <div class="font-bold text-slate-900">Hotel Pantai Indah</div>
                    <div class="text-xs text-slate-500">Booking System</div>
                </div>
            </a>

            <!-- Nav Items -->
            <div class="flex items-center gap-6">
                @auth
                    <!-- Admin Navigation -->
                    @if(Auth::check())
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                            📊 Admin
                        </a>
                        <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                🚪 Logout
                            </button>
                        </form>
                    @endif
                @else
                    <!-- Guest Navigation -->
                    <a href="{{ route('auth.showLogin') }}" class="text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('auth.showRegister') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ALERTS (Success, Error, etc) -->
    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="font-semibold text-red-900 mb-2">❌ Terjadi Kesalahan</p>
                <ul class="text-red-800 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 text-sm">✅ {{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-red-800 text-sm">❌ {{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-semibold text-slate-900 mb-4">Hotel Pantai Indah</h3>
                    <p class="text-slate-600 text-sm">Sistem booking hotel online terpadu untuk kemudahan tamu dan manajemen hotel.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Home</a></li>
                        <li><a href="{{ route('room.list') }}" class="hover:text-blue-600">Daftar Kamar</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-blue-600">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-4">Kontak</h4>
                    <p class="text-sm text-slate-600">
                        📞 +62 812 3456 7890<br>
                        📧 info@hotelpantaiindah.com<br>
                        📍 Jl. Pantai No. 123, Bali
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-4">Jam Operasional</h4>
                    <p class="text-sm text-slate-600">
                        Senin - Jumat: 08:00 - 22:00<br>
                        Sabtu - Minggu: 24 Jam<br>
                        Libur Nasional: 24 Jam
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-200 mt-8 pt-8">
                <p class="text-center text-slate-600 text-sm">
                    &copy; 2026 Hotel Pantai Indah. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
