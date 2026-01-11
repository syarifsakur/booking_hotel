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
                            Rp {{ number_format($room->price_per_night ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-slate-600 hidden md:table-cell">
                            {{ $room->capacity }} orang
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="text-blue-500 hover:text-blue-700" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687 1.688m-2.728-.364l-8.49 8.49a2 2 0 00-.497.83l-.64 2.24a.5.5 0 00.611.611l2.24-.64a2 2 0 00.83-.497l8.49-8.49m-2.544-3.18a1.875 1.875 0 112.652 2.652l-8.49 8.49a1 1 0 01-.415.252l-2.24.64.64-2.24a1 1 0 01.252-.415l8.49-8.49z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0v12m6-12v12M9 7l.447-1.342A1 1 0 0110.382 5h3.236a1 1 0 01.935.658L15 7m-9 0h12M7 7v12a2 2 0 002 2h6a2 2 0 002-2V7" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
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
