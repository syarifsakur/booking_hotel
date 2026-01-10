@extends('layouts.app')

@section('title', 'Daftar User')
@section('page-title', '👥 Daftar User')
@section('page-subtitle', 'Kelola semua pengguna sistem')

@section('content')
<!-- TABEL USER -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <!-- HEADER TABEL -->
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">Total User: {{ $users->total() }}</h2>
    </div>

    <!-- TABEL ISI -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Terdaftar Sejak</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-900">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-900 font-semibold">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                Aktif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            📭 Belum ada user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $users->links() }}
    </div>
</div>
@endsection
