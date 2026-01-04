<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hotel Pantai Indah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white">
                    <span class="font-bold">H</span>
                </div>
                <div>
                    <div class="font-bold text-slate-900">Hotel Pantai Indah</div>
                    <div class="text-xs text-slate-500">Admin Dashboard</div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- USER INFO -->
                <div class="text-right hidden md:block">
                    <div class="text-sm font-semibold text-slate-900">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <!-- TOMBOL LOGOUT -->
                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        
        <!-- WELCOME MESSAGE -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg mb-6">
                <div class="font-semibold">✓ {{ session('success') }}</div>
            </div>
        @endif

        <!-- PAGE TITLE -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-600 mt-1">Kelola hotel, kamar, dan booking dengan mudah</p>
        </div>

        <!-- STATISTIK CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            <!-- CARD 1: TOTAL KAMAR -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm">Total Kamar</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalRooms }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <span class="text-2xl">🛏️</span>
                    </div>
                </div>
                <a href="{{ route('admin.rooms') }}" class="text-blue-500 text-sm mt-3 inline-block hover:underline">
                    Lihat semua kamar →
                </a>
            </div>

            <!-- CARD 2: TOTAL BOOKING -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm">Total Booking</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalBookings }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <span class="text-2xl">📋</span>
                    </div>
                </div>
                <a href="{{ route('admin.bookings') }}" class="text-green-500 text-sm mt-3 inline-block hover:underline">
                    Lihat semua booking →
                </a>
            </div>

            <!-- CARD 3: TOTAL USER -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm">Total User</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <span class="text-2xl">👥</span>
                    </div>
                </div>
                <a href="{{ route('admin.users') }}" class="text-purple-500 text-sm mt-3 inline-block hover:underline">
                    Lihat semua user →
                </a>
            </div>

            <!-- CARD 4: PENDAPATAN (opsional) -->
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm">Info Cepat</p>
                        <p class="text-sm font-semibold text-slate-900 mt-2">
                            Semuanya berjalan normal ✓
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <span class="text-2xl">⚡</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- LAYOUT DUA KOLOM -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- BOOKING TERBARU -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow">
                    <!-- HEADER -->
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">📅 Booking Terbaru</h2>
                        <a href="{{ route('admin.bookings') }}" class="text-blue-500 text-sm hover:underline">
                            Lihat semua
                        </a>
                    </div>

                    <!-- TABEL -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Tamu</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentBookings as $booking)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-6 py-4 text-sm text-slate-900">
                                            {{ $booking->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            {{ $booking->user->email ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            {{ $booking->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                                Aktif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">
                                            Belum ada booking
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MENU CEPAT -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">⚙️ Menu Cepat</h2>
                
                <div class="space-y-3">
                    <!-- LINK KAMAR -->
                    <a href="{{ route('admin.rooms') }}" class="block px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-semibold transition">
                        🛏️ Kelola Kamar
                    </a>

                    <!-- LINK BOOKING -->
                    <a href="{{ route('admin.bookings') }}" class="block px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg font-semibold transition">
                        📋 Kelola Booking
                    </a>

                    <!-- LINK USER -->
                    <a href="{{ route('admin.users') }}" class="block px-4 py-3 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-semibold transition">
                        👥 Kelola User
                    </a>

                    <!-- DIVIDER -->
                    <div class="border-t border-slate-200 my-3"></div>

                    <!-- LOGOUT -->
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-semibold transition">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
