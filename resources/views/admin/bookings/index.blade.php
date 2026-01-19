@extends('layouts.app')

@section('title', 'Daftar Booking')
@section('page-title', '📋 Daftar Booking')
@section('page-subtitle', 'Kelola semua pemesanan hotel')

@section('content')
<!-- TABEL BOOKING -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <!-- HEADER TABEL -->
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">Total Booking: {{ $bookings->total() }}</h2>
    </div>

    <!-- TABEL ISI -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama Tamu</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Tanggal Booking</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Check-in</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Check-out</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Metode</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">KTP</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Bukti Bayar</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $index => $booking)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-900">
                            {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-900 font-semibold">
                            {{ $booking->guest_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $booking->guest_email ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ is_string($booking->created_at) ? $booking->created_at : $booking->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ is_string($booking->check_in) ? $booking->check_in : $booking->check_in->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ is_string($booking->check_out) ? $booking->check_out : $booking->check_out->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if ($booking->payment_method)
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $booking->payment_method === 'transfer' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $booking->payment_method === 'transfer' ? 'Transfer' : 'Bayar Langsung' }}
                                </span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if ($booking->guest_ktp_photo)
                                <a href="{{ asset('storage/' . $booking->guest_ktp_photo) }}" target="_blank" class="inline-flex items-center gap-2 hover:underline">
                                    <img src="{{ asset('storage/' . $booking->guest_ktp_photo) }}" alt="KTP" class="h-12 w-12 object-cover rounded border" />
                                </a>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if ($booking->proof_of_payment)
                                <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-2 hover:underline">
                                    <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" alt="Bukti bayar" class="h-12 w-12 object-cover rounded border" />
                                </a>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="px-3 py-1 rounded-full text-xs font-semibold border-0 cursor-pointer
                                    {{ $booking->status == 'aktif' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $booking->status == 'tidak_aktif' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $booking->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}">
                                    <option value="aktif" {{ $booking->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ $booking->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-500">
                            📭 Belum ada booking
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
