@extends('layouts.app')

@section('title', 'Pesan Kamar')

@section('content')
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Konfirmasi Pesanan</h1>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white p-6 shadow rounded">
      <form id="booking-form" method="POST" action="{{ route('guest.booking.store') }}">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nama Tamu</label>
          <input name="guest_name" required class="mt-1 block w-full border p-2 rounded" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input name="guest_email" class="mt-1 block w-full border p-2 rounded" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
            <input name="guest_phone" class="mt-1 block w-full border p-2 rounded" />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Check-in</label>
            <input id="check_in" name="check_in" type="date" required class="mt-1 block w-full border p-2 rounded" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Check-out</label>
            <input id="check_out" name="check_out" type="date" required class="mt-1 block w-full border p-2 rounded" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Qty</label>
            <input id="qty" name="qty" type="number" min="1" value="1" class="mt-1 block w-full border p-2 rounded" />
          </div>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700">Catatan</label>
          <textarea name="notes" class="mt-1 block w-full border p-2 rounded" rows="4"></textarea>
        </div>
      </form>
    </div>

    <div class="bg-white p-6 shadow rounded">
      <div class="mb-4">
        <h2 class="text-lg font-medium">Ringkasan Pemesanan</h2>
      </div>

      <div class="border p-4 rounded mb-4">
        <div class="flex justify-between">
          <div>
            <div class="font-semibold">{{ $room->name }}</div>
            <div class="text-sm text-gray-600">{{ $room->type }}</div>
          </div>
          <div class="text-right">
            <div class="font-semibold">Rp <span id="price_per_night">{{ number_format($room->price_per_night, 0, ',', '.') }}</span></div>
            <div class="text-sm text-gray-600">per malam</div>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <div class="flex justify-between text-sm text-gray-700">
          <div>Nights</div>
          <div id="nights_display">0</div>
        </div>
        <div class="flex justify-between text-sm text-gray-700">
          <div>Qty</div>
          <div id="qty_display">1</div>
        </div>
      </div>

      <div class="border-t pt-4">
        <div class="flex justify-between items-center">
          <div class="font-semibold">Total</div>
          <div class="text-2xl font-bold">Rp <span id="total_display">0</span></div>
        </div>

        <div class="mt-4">
          <button form="booking-form" type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Konfirmasi dan Bayar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const price = {{ $room->price_per_night }};
  const checkInEl = document.getElementById('check_in');
  const checkOutEl = document.getElementById('check_out');
  const qtyEl = document.getElementById('qty');
  const nightsDisplay = document.getElementById('nights_display');
  const qtyDisplay = document.getElementById('qty_display');
  const totalDisplay = document.getElementById('total_display');

  function updateTotals(){
    const inDate = new Date(checkInEl.value);
    const outDate = new Date(checkOutEl.value);
    let nights = 0;
    if (checkInEl.value && checkOutEl.value && outDate > inDate){
      nights = Math.ceil((outDate - inDate) / (1000*60*60*24));
    }
    const qty = Math.max(1, parseInt(qtyEl.value || 1));
    nightsDisplay.textContent = nights;
    qtyDisplay.textContent = qty;
    const total = nights * qty * price;
    totalDisplay.textContent = new Intl.NumberFormat('id-ID').format(total);
  }

  checkInEl.addEventListener('change', updateTotals);
  checkOutEl.addEventListener('change', updateTotals);
  qtyEl.addEventListener('input', updateTotals);

  // initial
  updateTotals();
</script>

@endsection
