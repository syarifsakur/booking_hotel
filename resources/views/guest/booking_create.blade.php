@extends('guest')

@section('title', 'Pesan Kamar')

@section('content')
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Konfirmasi Pesanan</h1>

  @if ($errors->any())
    <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      <div class="font-semibold mb-1">Periksa kembali data Anda:</div>
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white p-6 shadow rounded space-y-6">
      <form id="booking-form" method="POST" action="{{ route('guest.booking.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nama Tamu</label>
            <input name="guest_name" value="{{ old('guest_name') }}" required class="mt-1 block w-full border p-2 rounded" />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input name="guest_email" type="email" value="{{ old('guest_email') }}" required class="mt-1 block w-full border p-2 rounded" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
              <input name="guest_phone" value="{{ old('guest_phone') }}" required class="mt-1 block w-full border p-2 rounded" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Check-in</label>
              <input id="check_in" name="check_in" type="date" value="{{ old('check_in', request('check_in')) }}" min="{{ now()->toDateString() }}" required class="mt-1 block w-full border p-2 rounded" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Check-out</label>
              <input id="check_out" name="check_out" type="date" value="{{ old('check_out', request('check_out')) }}" min="{{ now()->toDateString() }}" required class="mt-1 block w-full border p-2 rounded" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <div class="mt-2 flex items-center gap-6">
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="payment_method" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }} required>
                <span>Bayar Langsung</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="payment_method" value="transfer" {{ old('payment_method') === 'transfer' ? 'checked' : '' }} required>
                <span>Transfer</span>
              </label>
            </div>
            <p class="text-xs text-gray-500 mt-1">Pilih "Transfer" untuk membayar via QRIS dan upload bukti.</p>
          </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Upload Identitas (KTP/SIM)</label>
              <input name="guest_ktp_photo" type="file" accept="image/*" class="mt-1 block w-full border p-2 rounded" />
              <p class="text-xs text-gray-500 mt-1">Opsional, format JPG/PNG, maks 2MB.</p>
            </div>

            <div id="transfer_section" class="hidden">
              <label class="block text-sm font-medium text-gray-700">QRIS Pembayaran</label>
              <div class="mt-1 border rounded p-3 bg-gray-50">
                @php($qrisImage = config('services.qris.image') ?? null)
                @if ($qrisImage)
                  <img src="{{ asset(ltrim($qrisImage, '/')) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                @else
                  <div class="text-xs text-gray-600">QRIS belum dikonfigurasi. Set env <b>QRIS_IMAGE</b> ke path publik (mis: /images/qris.png).</div>
                @endif
              </div>
              <label class="block text-sm font-medium text-gray-700 mt-4">Upload Bukti Pembayaran</label>
              <input name="proof_of_payment" type="file" accept="image/*" class="mt-1 block w-full border p-2 rounded" />
              <p class="text-xs text-gray-500 mt-1">Wajib jika memilih Transfer. Format JPG/PNG, maks 2MB.</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" class="mt-1 block w-full border p-2 rounded" rows="4"></textarea>
          </div>
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
  const nightsDisplay = document.getElementById('nights_display');
  const totalDisplay = document.getElementById('total_display');
  const transferSection = document.getElementById('transfer_section');
  const methodInputs = Array.from(document.querySelectorAll('input[name="payment_method"]'));

  function updateTotals(){
    const inDate = new Date(checkInEl.value);
    const outDate = new Date(checkOutEl.value);
    let nights = 0;
    if (checkInEl.value && checkOutEl.value && outDate > inDate){
      nights = Math.ceil((outDate - inDate) / (1000*60*60*24));
    }
    nightsDisplay.textContent = nights;
    const total = nights * price;
    totalDisplay.textContent = new Intl.NumberFormat('id-ID').format(total);
  }

  function updateMethodUI(){
    const selected = methodInputs.find(i => i.checked)?.value;
    transferSection.classList.toggle('hidden', selected !== 'transfer');
  }

  checkInEl.addEventListener('change', updateTotals);
  checkOutEl.addEventListener('change', updateTotals);
  methodInputs.forEach(i => i.addEventListener('change', updateMethodUI));

  // initial
  updateTotals();
  updateMethodUI();
</script>

@endsection
