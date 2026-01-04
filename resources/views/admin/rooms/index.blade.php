<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white">
                    <span class="font-bold">H</span>
                </div>
                <div>
                    <div class="font-bold text-slate-900">Hotel Pantai Indah</div>
                    <div class="text-xs text-slate-500">Admin Dashboard</div>
                </div>
            </a>

            <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        
        <!-- BREADCRUMB -->
        <div class="text-sm text-slate-600 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
            <span class="mx-2">→</span>
            <span class="font-semibold text-slate-900">Daftar Kamar</span>
        </div>

        <!-- PAGE HEADER -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">🛏️ Daftar Kamar</h1>
                <p class="text-slate-600 mt-1">Kelola semua kamar hotel Anda</p>
            </div>
            <a href="{{ route('admin.rooms.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                ➕ Tambah Kamar
            </a>
        </div>

        <!-- TABEL KAMAR -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- HEADER TABEL -->
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="font-bold text-slate-900">Total Kamar: {{ $rooms->total() }}</h2>
            </div>

            <!-- TABEL ISI -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama Kamar</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Tipe</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Harga</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Kapasitas</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $index => $room)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ ($rooms->currentPage() - 1) * $rooms->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900 font-semibold">
                                    {{ $room->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $room->type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900 font-semibold">
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $room->capacity }} orang
                                </td>
                                <td class="px-6 py-4 text-center text-sm">
                                    <button class="text-blue-500 hover:text-blue-700 font-semibold">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    📭 Belum ada kamar
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $rooms->links() }}
            </div>
        </div>

    </div>

</body>
</html>
