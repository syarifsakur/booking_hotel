@extends('layouts.app')

@section('title', 'Edit Kamar')
@section('page-title', '✏️ Edit Kamar')
@section('page-subtitle', 'Perbarui detail kamar')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama/Nomor Kamar <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name', $room->name) }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kamar <span class="text-red-500">*</span></label>
            <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror" required>
                <option value="">-- Pilih Tipe Kamar --</option>
                <option value="Single" @selected(old('type', $room->type) == 'Single')>Single Room</option>
                <option value="Double" @selected(old('type', $room->type) == 'Double')>Double Room</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="price_per_night" class="block text-sm font-semibold text-gray-700 mb-2">Harga Per Malam (Rp) <span class="text-red-500">*</span></label>
            <input type="number" id="price_per_night" name="price_per_night" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price_per_night') border-red-500 @enderror" value="{{ old('price_per_night', $room->price_per_night) }}" min="0" step="1000" required>
            @error('price_per_night')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">Kapasitas Tamu <span class="text-red-500">*</span></label>
            <select id="capacity" name="capacity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('capacity') border-red-500 @enderror" required>
                <option value="">-- Pilih Kapasitas --</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" @selected(old('capacity', $room->capacity) == $i)>{{ $i }} Orang</option>
                @endfor
            </select>
            @error('capacity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">Foto Kamar (opsional)</label>
            <input type="file" id="photo" name="photo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('photo') border-red-500 @enderror" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/bmp" onchange="previewImage(event)">
            @error('photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Format: JPEG, PNG, GIF, WebP, BMP | Max: 5MB | Otomatis dikonversi ke JPEG</p>
            @if ($room->photo)
                <div class="mt-3">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $room->photo) }}" alt="Foto kamar" class="w-48 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            @endif
            <div id="imagePreview" class="mt-3 hidden">
                <p class="text-sm font-semibold text-gray-700 mb-2">Preview baru:</p>
                <img id="preview" class="w-48 h-32 object-cover rounded-lg border border-gray-300" alt="Preview">
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kamar</label>
            <textarea id="description" name="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Contoh: Kamar bersih dengan AC, TV, WiFi gratis...">{{ old('description', $room->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" class="w-4 h-4 text-blue-500 rounded focus:ring-2 focus:ring-blue-500" @checked(old('is_active', $room->is_active))>
                <span class="ml-2 text-gray-700">Kamar Aktif (tersedia untuk booking)</span>
            </label>
            @error('is_active')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-4 border-t border-gray-200">
            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">Simpan Perubahan</button>
            <a href="{{ route('admin.rooms') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition text-center">Batal</a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
