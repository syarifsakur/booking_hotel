@extends('guest')

@section('title', 'Detail Kamar - ' . $room->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('room.list') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar Kamar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Foto Kamar -->
        <div class="md:col-span-2">
            @if($room->photo)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img 
                        src="{{ asset('storage/' . $room->photo) }}" 
                        alt="{{ $room->name }} - {{ $room->type }}" 
                        title="Kamar {{ $room->name }}"
                        class="w-full h-96 object-cover"
                        loading="eager"
                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-gray-200 h-96 flex items-center justify-center\'><div class=\'text-center\'><svg class=\'mx-auto w-16 h-16 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-gray-500 text-lg mt-4\'>📷 Foto tidak tersedia</p></div></div>';"
                    >
                </div>
            @else
                <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg mt-4">📷 Foto tidak tersedia</p>
                    </div>
                </div>
            @endif

            <!-- Info Kamar -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Deskripsi Kamar</h2>
                @if($room->description)
                    <p class="text-gray-700 leading-relaxed">{{ $room->description }}</p>
                @else
                    <p class="text-gray-500">Tidak ada deskripsi</p>
                @endif
            </div>
        </div>

        <!-- Info Booking -->
        <div>
            <!-- Card Info Kamar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                <!-- Nama & Tipe -->
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $room->name }}</h1>
                <div class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mb-4">
                    {{ $room->type }}
                </div>

                <!-- Harga -->
                <div class="mb-6 border-b border-gray-200 pb-6">
                    <p class="text-gray-600 text-sm mb-2">Harga Per Malam</p>
                    <p class="text-3xl font-bold text-green-600">
                        Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Kapasitas -->
                <div class="mb-6 flex items-center gap-4">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm">Kapasitas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $room->capacity }} Orang</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>

                <!-- Status -->
                @if($room->is_active)
                    <div class="mb-4 flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 px-3 py-2">
                        <span class="text-green-700 text-sm font-semibold">✅ Kamar Tersedia</span>
                    </div>
                @else
                    <div class="mb-4 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 px-3 py-2">
                        <span class="text-red-700 text-sm font-semibold">❌ Kamar Tidak Tersedia</span>
                    </div>
                @endif

                <!-- Tombol Booking -->
                @if($room->is_active)
                    <a 
                        href="{{ route('guest.booking.create', $room->id) }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2"
                    >
                        📅 Pesan Kamar
                    </a>
                @else
                    <button 
                        disabled
                        class="w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed"
                    >
                        ❌ Tidak Tersedia
                    </button>
                @endif

                <!-- Kalender Ketersediaan -->
                <div class="mt-6">
                    <button type="button" id="toggleAvailability" class="w-full inline-flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        <span>Kalender Ketersediaan ({{ $calendar['monthLabel'] }})</span>
                        <span id="chevron" class="transition">▼</span>
                    </button>
                    <div id="availabilityPanel" class="mt-4 hidden">
                        <form method="GET" action="{{ route('room.detail', $room->id) }}" class="mb-3 flex items-center gap-2 text-sm">
                            <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                            <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                            <label class="text-slate-600">Pilih bulan:</label>
                            <select name="month" class="rounded border border-slate-300 px-3 py-2 text-sm" onchange="this.form.submit()">
                                @foreach($monthOptions as $opt)
                                    <option value="{{ $opt['value'] }}" {{ $opt['value'] === $calendar['monthValue'] ? 'selected' : '' }}>
                                        {{ $opt['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <div class="flex items-center gap-3 text-xs mb-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 text-green-700 border border-green-200 px-3 py-1">● Tersedia</span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-50 text-red-700 border border-red-200 px-3 py-1">● Booked</span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-500 border border-slate-200 px-3 py-1">● Di luar bulan</span>
                        </div>
                        <div class="overflow-hidden rounded-lg border border-slate-200">
                            <div class="grid grid-cols-7 bg-slate-50 text-[11px] font-semibold text-slate-600">
                                <div class="p-2 text-center">Sen</div>
                                <div class="p-2 text-center">Sel</div>
                                <div class="p-2 text-center">Rab</div>
                                <div class="p-2 text-center">Kam</div>
                                <div class="p-2 text-center">Jum</div>
                                <div class="p-2 text-center">Sab</div>
                                <div class="p-2 text-center">Min</div>
                            </div>
                            @foreach($calendar['weeks'] as $week)
                                <div class="grid grid-cols-7 text-sm">
                                    @foreach($week as $day)
                                        <div class="min-h-[70px] p-2 border-t border-slate-100 flex flex-col gap-1 {{ $day['in_month'] ? '' : 'bg-slate-50 text-slate-400' }}
                                            {{ $day['status'] === 'booked' ? 'bg-red-50 text-red-700 border-red-100' : '' }}">
                                            <div class="text-xs font-semibold">{{ $day['day'] }}</div>
                                            @if($day['status'] === 'booked')
                                                <span class="text-[11px] rounded-full bg-red-100 text-red-700 px-2 py-[2px] w-max">Booked</span>
                                            @elseif($day['in_month'])
                                                <span class="text-[11px] rounded-full bg-green-100 text-green-700 px-2 py-[2px] w-max">Tersedia</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <script>
                // Toggle jadwal ketersediaan
                (function() {
                    const btn = document.getElementById('toggleAvailability');
                    const panel = document.getElementById('availabilityPanel');
                    const chevron = document.getElementById('chevron');
                    if (btn && panel && chevron) {
                        btn.addEventListener('click', () => {
                            const isHidden = panel.classList.contains('hidden');
                            panel.classList.toggle('hidden');
                            chevron.textContent = isHidden ? '▲' : '▼';
                        });
                    }
                })();
                </script>
            </div>

        </div>
    </div>

    <!-- Review / Testimoni -->
    <div class="mt-12 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ Ulasan Tamu</h2>
        <div class="space-y-4">
            <div class="border-b border-gray-200 pb-4">
                <div class="flex items-center gap-2 mb-2">
                    <p class="font-semibold text-gray-800">Rina Wijaya</p>
                    <div class="text-yellow-400">★★★★★</div>
                </div>
                <p class="text-gray-600">Kamar yang sangat nyaman dan bersih. Pelayanan ramah. Pasti akan menginap lagi!</p>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <div class="flex items-center gap-2 mb-2">
                    <p class="font-semibold text-gray-800">Ahmad Pratama</p>
                    <div class="text-yellow-400">★★★★</div>
                </div>
                <p class="text-gray-600">Lokasi bagus, fasilitas lengkap. Hanya sarannya AC bisa lebih dingin.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky {
        position: sticky;
    }
</style>
@endsection
