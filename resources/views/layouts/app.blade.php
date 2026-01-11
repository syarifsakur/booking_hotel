<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Hotel Booking System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-100">

    <div class="flex flex-col lg:flex-row min-h-screen">
        <aside class="w-full lg:w-64 bg-slate-900 text-white flex flex-col lg:fixed lg:h-full lg:left-0 lg:top-0">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500 text-white font-bold">
                        H
                    </div>
                    <div>
                        <div class="font-bold text-white">Hotel Admin</div>
                        <div class="text-xs text-slate-400">Management Panel</div>
                    </div>
                </a>
            </div>

            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-1 hidden lg:block">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800' : '' }}">
                    <span class="text-lg">📊</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.rooms') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('admin.rooms*') ? 'bg-slate-800' : '' }}">
                    <span class="text-lg">🏨</span>
                    <span class="text-sm font-medium">Kelola Kamar</span>
                </a>
                <a href="{{ route('admin.bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('admin.bookings') ? 'bg-slate-800' : '' }}">
                    <span class="text-lg">📅</span>
                    <span class="text-sm font-medium">Booking</span>
                </a>
                <a href="{{ route('admin.bookings.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('admin.bookings.history') ? 'bg-slate-800' : '' }}">
                    <span class="text-lg">📜</span>
                    <span class="text-sm font-medium">Riwayat Booking</span>
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-slate-700 hidden lg:block">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-xs text-slate-400">Administrator</div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2">
                        <span>🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 w-full lg:ml-64 flex flex-col min-h-screen">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-4 md:px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-lg md:text-xl font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-xs md:text-sm text-slate-600">@yield('page-subtitle', 'Kelola sistem booking hotel')</p>
                    </div>
                    <div class="text-xs md:text-sm text-slate-600 whitespace-nowrap">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </header>

            <!-- ALERTS -->
            <div class="px-4 md:px-6 py-4">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <p class="font-semibold text-red-900 mb-2">❌ Terjadi Kesalahan</p>
                        <ul class="text-red-800 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <p class="text-green-800 text-sm">✅ {{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <p class="text-red-800 text-sm">❌ {{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <!-- PAGE CONTENT -->
            <main class="flex-1 px-4 md:px-6 pb-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 mt-8">
                <div class="px-4 md:px-6 py-4">
                    <p class="text-center text-slate-600 text-xs md:text-sm">
                        &copy; 2026 Hotel Pantai Indah. Admin Panel - Semua hak dilindungi.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
