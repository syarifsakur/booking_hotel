# 📸 Dokumentasi Upload Foto Kamar

## Fitur Utama

### ✅ Konversi Otomatis ke JPEG

Semua foto yang diupload akan **otomatis dikonversi ke format JPEG** untuk:

-   ✓ Kompatibilitas maksimal di semua browser
-   ✓ Dapat dibuka di Google Images dan search engines
-   ✓ Optimasi ukuran file untuk web
-   ✓ Loading lebih cepat

### 📥 Format yang Didukung

Upload foto dengan format berikut:

-   JPEG / JPG ✓
-   PNG ✓
-   GIF ✓
-   WebP ✓
-   BMP ✓

**Ukuran maksimal: 5MB**

### 🔄 Proses Upload

1. **Upload File** → Form menerima berbagai format gambar
2. **Konversi** → Gambar otomatis dikonversi ke JPEG
3. **Resize** → Jika lebih besar dari 1200px, akan di-resize
4. **Optimasi** → Kompresi dengan quality 85% untuk balance kualitas & ukuran
5. **Simpan** → Disimpan di `storage/app/public/rooms/`

### 🎯 Keuntungan Format JPEG

-   **Universal**: Dibuka di semua browser dan device
-   **SEO Friendly**: Google dapat mengindex dengan baik
-   **Optimized**: Ukuran file lebih kecil dari PNG
-   **Web Standard**: Format standar untuk foto web

### 📝 Implementasi Teknis

#### Controller: `AdminController::storeRoom()`

```php
if ($request->hasFile('photo')) {
    $file = $request->file('photo');

    // Generate nama file unik dengan format JPEG
    $filename = time() . '_' . uniqid() . '.jpg';
    $storagePath = storage_path('app/public/rooms');

    // Konversi dan optimasi foto ke JPEG
    $this->convertAndOptimizeImage($file->getRealPath(), $fullPath);

    $validated['photo'] = 'rooms/' . $filename;
}
```

#### Method: `convertAndOptimizeImage()`

Fungsi ini menggunakan **GD Library** untuk:

1. Deteksi format gambar asli
2. Load gambar sesuai format (JPEG, PNG, GIF, WebP, BMP)
3. Resize jika lebih besar dari 1200px (mempertahankan aspect ratio)
4. Convert background transparan ke putih
5. Simpan sebagai JPEG dengan quality 85%

### 🖼️ Preview & Display

#### Form Create Room

-   Preview langsung saat memilih foto
-   JavaScript menampilkan preview sebelum upload
-   Info format dan ukuran file

#### Halaman Room List

-   Lazy loading untuk performa
-   Fallback SVG jika foto error/tidak ada
-   Alt text untuk SEO

#### Halaman Room Detail

-   Eager loading untuk foto utama
-   Error handling dengan fallback
-   SEO meta tags untuk sharing

### 🔗 SEO & Social Media

File `guest.blade.php` sudah dilengkapi dengan:

```html
<!-- Open Graph / Facebook -->
<meta property="og:image" content="foto-kamar.jpg" />

<!-- Twitter Card -->
<meta property="twitter:image" content="foto-kamar.jpg" />

<!-- SEO -->
<meta name="description" content="..." />
```

### 🛠️ Teknologi

-   **Backend**: Laravel + GD Library
-   **Storage**: Symbolic link (`php artisan storage:link`)
-   **Format Output**: JPEG (Quality 85%)
-   **Max Width**: 1200px
-   **Lazy Load**: Native `loading="lazy"`

### 📦 File & Folder

```
storage/app/public/rooms/
├── 1736484923_abc123.jpg
├── 1736484924_def456.jpg
└── ...

public/storage → symlink ke storage/app/public
```

### 🚀 Cara Test

1. Buka halaman admin: `/admin/rooms/create`
2. Upload foto dengan format PNG/GIF/WebP/BMP
3. Foto akan otomatis dikonversi ke JPEG
4. Cek di folder `storage/app/public/rooms/`
5. Lihat hasil di halaman room list

### 💡 Tips

-   Gunakan foto dengan resolusi minimal 800x600px
-   Foto landscape lebih baik daripada portrait
-   Cahaya yang baik membuat foto lebih menarik
-   Hindari foto blur atau pecah

## ✨ Kesimpulan

Dengan sistem konversi otomatis ke JPEG:

-   ✅ Foto pasti bisa dibuka di Google
-   ✅ Kompatibel dengan semua browser
-   ✅ Loading website lebih cepat
-   ✅ SEO friendly
-   ✅ User tidak perlu khawatir format foto
