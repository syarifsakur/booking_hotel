# 📋 DOKUMENTASI FITUR BOOKING DENGAN QR CODE

## 🎯 Fitur Baru Ditambahkan

### 1. Upload Foto Kamar (Admin)

-   Kolom `photo` ditambahkan ke tabel `rooms`
-   Admin dapat upload foto ketika menambah kamar
-   Format: JPEG, PNG, GIF | Max: 2MB
-   Foto disimpan di `storage/app/public/rooms/`

### 2. Detail Kamar dengan Foto (Guest)

-   Halaman detail kamar menampilkan foto berkualitas tinggi
-   Informasi lengkap: tipe, harga, kapasitas, deskripsi
-   Button "Pesan Kamar" untuk navigate ke form booking

### 3. QR Code Booking (Guest)

-   QR code otomatis generate setelah booking berhasil
-   Data dalam QR code: booking code, nama, email, WA, room, tanggal, harga
-   QR code ditampilkan di halaman booking_thanks
-   Bisa di-print atau di-screenshot

---

## 📁 File yang Diubah/Ditambah

### Modified Files

| File                                                           | Perubahan                  |
| -------------------------------------------------------------- | -------------------------- |
| `database/migrations/2026_01_01_143438_create_rooms_table.php` | Tambah kolom `photo`       |
| `app/Models/Room.php`                                          | Tambah `photo` ke fillable |
| `app/Http/Controllers/AdminController.php`                     | Handle upload foto         |
| `resources/views/admin/rooms/create.blade.php`                 | Tambah form upload foto    |
| `app/Http/Controllers/Guest/BookingController.php`             | Generate QR code data      |
| `app/Models/Booking.php`                                       | Tambah field ke fillable   |
| `resources/views/guest/booking_thanks.blade.php`               | Tampilkan QR code          |

### New Files

| File                                                            | Fungsi                          |
| --------------------------------------------------------------- | ------------------------------- |
| `database/migrations/2026_01_04_100000_add_photo_to_rooms.php`  | Tambah kolom photo              |
| `database/migrations/2026_01_04_000000_add_booking_details.php` | Tambah field WA, KTP, QR code   |
| `app/Helpers/QrCodeHelper.php`                                  | Helper untuk QR code generation |
| `resources/views/guest/room_detail.blade.php`                   | Detail kamar dengan foto        |

### Already Exists

-   `resources/views/guest/booking_create.blade.php` (form booking)
-   `app/Http/Controllers/RoomDetailController.php` (updated untuk use DB)

---

## 🔧 CARA KERJA

### A. Upload Foto Kamar (Admin)

**Flow:**

```
1. Admin login & buka Admin Dashboard
2. Klik "Daftar Kamar"
3. Klik tombol "➕ Tambah Kamar"
4. Isi form termasuk upload foto
5. Klik "Simpan Kamar"
6. Foto disimpan ke: storage/app/public/rooms/{timestamp}_{filename}.ext
7. Foto path disimpan di database: rooms.photo = 'rooms/{filename}'
```

**Code di AdminController::storeRoom():**

```php
if ($request->hasFile('photo')) {
    $file = $request->file('photo');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->storeAs('public/rooms', $filename);
    $validated['photo'] = 'rooms/' . $filename;
}
```

---

### B. Tampilkan Detail Kamar dengan Foto (Guest)

**Flow:**

```
1. Guest buka halaman daftar kamar: /room
2. Guest klik salah satu kamar
3. RoomDetailController::show($id) dijalankan
4. Ambil kamar dari database: Room::findOrFail($id)
5. Return view 'guest.room_detail' dengan data kamar
6. Di view, tampilkan:
   - Foto kamar (jika ada)
   - Nama, tipe, harga, kapasitas
   - Deskripsi & fasilitas
   - Tombol "Pesan Kamar" -> redirect ke booking form
```

**Di View:**

```blade
@if($room->photo && file_exists(storage_path('app/public/' . $room->photo)))
    <img src="{{ asset('storage/' . $room->photo) }}" alt="{{ $room->name }}">
@else
    <p>Foto tidak tersedia</p>
@endif
```

---

### C. Generate & Tampilkan QR Code Booking (Guest)

**Flow:**

```
1. Guest isi form booking & klik "Lanjutkan Pemesanan"
2. BookingController::store() dijalankan
3. Validasi input
4. Buat Booking record
5. Buat BookingItem record
6. Generate QR code data:
   - JSON encode: {booking_code, guest_name, email, WA, room, tanggal, harga}
   - Simpan ke: booking.qr_code_data
7. Save booking ke database
8. Redirect ke booking_thanks page
9. Di halaman thanks:
   - Generate QR image dari qr_code_data
   - Tampilkan di sidebar (sticky/print-friendly)
   - Data booking ditampilkan lengkap (kanan)
```

**Code QR Generation:**

```php
$qrData = json_encode([
    'booking_code' => $booking->booking_code,
    'guest_name' => $booking->guest_name,
    'guest_email' => $booking->guest_email,
    'room_name' => $room->name,
    'check_in' => $booking->check_in,
    'check_out' => $booking->check_out,
    'total_price' => $booking->total_price,
]);

$booking->qr_code_data = $qrData;
$booking->save();
```

**Di Blade View:**

```blade
@php
    $qrCode = new \Endroid\QrCode\QrCode($booking->qr_code_data);
    $qrCode->setErrorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High);
    $qrCode->setSize(250);
    $qrCode->setMargin(10);
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $result = $writer->write($qrCode);
@endphp
<img src="{{ $result->getDataUri() }}" alt="QR Code">
```

---

## 📊 DATABASE STRUCTURE

### Tabel `rooms` (Updated)

```
id              | INT (Primary Key)
name            | VARCHAR (Nama/nomor kamar)
type            | VARCHAR (Tipe: Single, Double, Suite)
price_per_night | INT (Harga per malam)
capacity        | INT (Jumlah tamu)
description     | TEXT
photo           | VARCHAR ✨ NEW (Path foto)
is_active       | BOOLEAN
created_at      | TIMESTAMP
updated_at      | TIMESTAMP
```

### Tabel `bookings` (Updated)

```
id              | INT (Primary Key)
booking_code    | VARCHAR (Kode unik)
qr_token        | VARCHAR
guest_name      | VARCHAR
guest_email     | VARCHAR
guest_phone     | VARCHAR
guest_whatsapp  | VARCHAR ✨ NEW
guest_ktp_photo | VARCHAR ✨ NEW (For future use)
check_in        | DATE
check_out       | DATE
nights          | INT
total_price     | INT
payment_status  | ENUM (unpaid, paid, expired, cancelled)
qr_code_data    | TEXT ✨ NEW (JSON data dalam QR)
paid_at         | TIMESTAMP
expires_at      | TIMESTAMP
created_at      | TIMESTAMP
updated_at      | TIMESTAMP
```

---

## 🧪 TESTING

### Test 1: Upload Foto Kamar

```
1. Login admin: admin@hotel.com / admin123
2. Daftar Kamar → ➕ Tambah Kamar
3. Isi form:
   - Nama: 101
   - Tipe: Single
   - Harga: 500000
   - Kapasitas: 1
   - Foto: pilih file (JPG/PNG max 2MB)
4. Simpan
✅ Expected: Foto tersimpan di storage/app/public/rooms/
✅ Expected: Path disimpan di database
```

### Test 2: Lihat Detail Kamar

```
1. Logout atau buka tab private
2. Buka: /room (daftar kamar)
3. Klik salah satu kamar
✅ Expected: Buka halaman detail dengan foto
✅ Expected: Tampil info: tipe, harga, kapasitas, deskripsi
✅ Expected: Tombol "📅 Pesan Kamar"
```

### Test 3: Booking & Generate QR Code

```
1. Di halaman detail kamar, klik "📅 Pesan Kamar"
2. Isi form booking:
   - Nama: Test User
   - Email: test@email.com
   - WA: 082123456789
   - Check-in: 2026-01-10
   - Check-out: 2026-01-12
3. Klik "Lanjutkan Pemesanan"
✅ Expected: Redirect ke booking_thanks
✅ Expected: QR code ditampilkan di sidebar
✅ Expected: Data booking ditampilkan lengkap
✅ Expected: Tombol Print tersedia
```

### Test 4: Print Booking Confirmation

```
1. Di halaman booking_thanks
2. Klik tombol "🖨️ Print"
✅ Expected: Print dialog muncul
✅ Expected: QR code ikut ter-print
✅ Expected: Data booking ter-print rapi
```

---

## 📋 VALIDASI

### Upload Foto

-   ✓ Format: JPEG, PNG, GIF
-   ✓ Max size: 2MB
-   ✓ Opsional (tidak wajib)

### QR Code

-   ✓ Otomatis generate saat booking sukses
-   ✓ Menyimpan semua data penting
-   ✓ Error correction level: High (bisa scan meski rusak 30%)
-   ✓ Size: 250x250px dengan margin 10px

---

## 🎨 TAMPILAN

### Halaman Detail Kamar

```
┌──────────────────────┬─────────────────────┐
│   Foto Kamar         │  Info Kamar         │
│   (Besar)            │  - Nama/Tipe        │
│                      │  - Harga            │
│                      │  - Kapasitas        │
│                      │  - Status           │
│                      │  [Pesan Kamar]      │
│                      │                     │
└──────────────────────┴─────────────────────┘
│ Deskripsi & Fasilitas                       │
└─────────────────────────────────────────────┘
│ Review Tamu                                 │
└─────────────────────────────────────────────┘
```

### Halaman Booking Thanks

```
┌─────────────┬──────────────────────┐
│ QR Code     │  Success Header      │
│ (Sticky)    │  ✅ Booking Berhasil │
│ [Print]     │                      │
├─────────────┤  Data Tamu           │
│             │  Detail Reservasi    │
│             │  Pricing             │
│             │  Status Pembayaran   │
│             │  Info Penting        │
│             │  [Buttons]           │
└─────────────┴──────────────────────┘
```

---

## 🔐 KEAMANAN

-   ✓ File upload validated (type & size)
-   ✓ File stored di folder khusus (/storage)
-   ✓ QR code hanya menyimpan data publik (tidak ada password)
-   ✓ Booking linked ke user via email/phone
-   ✓ CSRF protection di form

---

## 📦 DEPENDENCIES

-   `endroid/qr-code` (^6.0)
-   Laravel built-in Storage

---

## 🚀 NEXT STEPS (Optional)

-   [ ] Upload KTP saat booking
-   [ ] Email confirmation dengan QR code attachment
-   [ ] Dashboard admin untuk melihat booking dengan QR
-   [ ] SMS notification dengan booking details
-   [ ] Payment gateway integration
-   [ ] Check-in confirmation scan QR code

---

**Fitur booking dengan QR code sudah SIAP DIGUNAKAN! 🎉**
