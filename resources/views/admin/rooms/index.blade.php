@extends('layouts.app')

@section('title', 'Daftar Kamar')
@section('page-title', '🛏️ Daftar Kamar')
@section('page-subtitle', 'Kelola semua kamar hotel Anda')

@section('content')
<div class="mb-4 md:mb-6 flex flex-col sm:flex-row sm:justify-end gap-2">
    <a href="{{ route('admin.rooms.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 md:px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2 text-sm md:text-base">
        ➕ Tambah Kamar
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-4 md:px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900 text-sm md:text-base">Total Kamar: {{ $rooms->total() }}</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs md:text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">No</th>
                    <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Nama Kamar</th>
                    <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700 hidden sm:table-cell">Tipe</th>
                    <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700">Harga</th>
                    <th class="px-3 md:px-6 py-3 text-left font-semibold text-slate-700 hidden md:table-cell">Kapasitas</th>
                    <th class="px-3 md:px-6 py-3 text-center font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rooms as $index => $room)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-900">
                            {{ ($rooms->currentPage() - 1) * $rooms->perPage() + $index + 1 }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-900 font-semibold">
                            {{ $room->name }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-600 hidden sm:table-cell">
                            {{ $room->type }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-900 font-semibold">
                            Rp {{ number_format($room->price, 0, ',', '.') }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-600 hidden md:table-cell">
                            {{ $room->capacity }} orang
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                            <button class="text-blue-500 hover:text-blue-700 font-semibold text-xs md:text-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 md:px-6 py-6 md:py-8 text-center text-slate-500 text-sm">
                            📭 Belum ada kamar
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 md:px-6 py-3 md:py-4 border-t border-slate-200 bg-slate-50">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
