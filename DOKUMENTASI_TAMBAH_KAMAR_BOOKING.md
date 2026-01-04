# 📚 PENJELASAN FITUR TAMBAH KAMAR & BOOKING

## 1️⃣ FITUR TAMBAH KAMAR (ADMIN)

### 📍 Lokasi File

-   **Controller:** `app/Http/Controllers/AdminController.php` (method `createRoom()` dan `storeRoom()`)
-   **View:** `resources/views/admin/rooms/create.blade.php`
-   **Route:**
    -   GET `/admin/rooms/create` → menampilkan form
    -   POST `/admin/rooms` → menyimpan data

---

## 🔧 CARA KERJA TAMBAH KAMAR

### A. FLOW DIAGRAM

```
Admin Klik "Tambah Kamar"
         ↓
GET /admin/rooms/create
         ↓
AdminController::createRoom()
         ↓
Tampilkan Form (create.blade.php)
         ↓
Admin Isi Form & Klik "Simpan"
         ↓
POST /admin/rooms (dengan data form)
         ↓
AdminController::storeRoom() - Validasi Data
         ↓
Jika INVALID → Kembali ke form dengan error
         ↓
Jika VALID → Simpan ke Database
         ↓
Redirect ke /admin/rooms dengan pesan sukses
```

---

## 📝 CODE PENJELASAN - TAMBAH KAMAR

### A. METHOD `createRoom()` - TAMPILKAN FORM

```php
public function createRoom()
{
    return view('admin.rooms.create');
}
```

**Penjelasan:**

-   Fungsi sederhana yang hanya menampilkan view form
-   `view('admin.rooms.create')` = tampilkan file `resources/views/admin/rooms/create.blade.php`
-   Tidak perlu kirim data apapun ke view

---

### B. METHOD `storeRoom()` - SIMPAN DATA

```php
public function storeRoom(Request $request)
{
    // LANGKAH 1: VALIDASI INPUT
    $validated = $request->validate([
        'no_room' => 'required|string|unique:rooms|max:10',
        'price' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:1|max:10',
        'description' => 'nullable|string|max:1000',
        'is_active' => 'boolean',
    ]);
```

**Penjelasan Validasi:**

| Rule            | Arti                                                         |
| --------------- | ------------------------------------------------------------ |
| `required`      | Field wajib diisi, tidak boleh kosong                        |
| `string`        | Harus berupa teks                                            |
| `unique:rooms`  | Nomor kamar harus unik (tidak boleh duplikat di tabel rooms) |
| `max:10`        | Maximum 10 karakter                                          |
| `numeric`       | Harus angka                                                  |
| `min:0`         | Nilai minimal 0                                              |
| `integer`       | Harus bilangan bulat                                         |
| `min:1\|max:10` | Minimal 1 orang, maksimal 10 orang                           |
| `nullable`      | Boleh kosong (tidak wajib)                                   |
| `boolean`       | Harus true/false                                             |

**Jika Validasi Gagal:**

-   Otomatis redirect kembali ke form
-   Tampilkan error message di bawah field yang salah
-   Data yang sudah diisi tetap tersimpan (menggunakan `old()`)

---

```php
    // LANGKAH 2: SET STATUS DEFAULT
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    // LANGKAH 3: BUAT KAMAR BARU
    Room::create($validated);

    // LANGKAH 4: REDIRECT DENGAN PESAN SUKSES
    return redirect()->route('admin.rooms')
                     ->with('success', 'Kamar berhasil ditambahkan!');
}
```

**Penjelasan Lanjutan:**

1. **Set Status Default**

    ```php
    $request->has('is_active') ? 1 : 0
    ```

    - `$request->has('is_active')` = cek apakah checkbox dicentang
    - Jika ya = `1` (aktif), jika tidak = `0` (tidak aktif)

2. **Simpan ke Database**

    ```php
    Room::create($validated)
    ```

    - `Room::create()` = method untuk membuat record baru di database
    - Menggunakan mass assignment (bulk insert semua field)
    - Database secara otomatis generate `uuid` dan `timestamps`

3. **Redirect dengan Pesan**
    ```php
    return redirect()->route('admin.rooms')
                     ->with('success', 'Kamar berhasil ditambahkan!')
    ```
    - `redirect()` = arahkan ke halaman lain
    - `route('admin.rooms')` = halaman daftar kamar
    - `with('success', '...')` = kirim pesan sukses yang ditampilkan di halaman berikutnya

---

## 2️⃣ FITUR TAMBAH BOOKING (GUEST)

### 📍 Lokasi File

-   **Controller:** `app/Http/Controllers/Guest/BookingController.php` (method `create()` dan `store()`)
-   **View:** `resources/views/guest/booking_create.blade.php`
-   **Route:**
    -   GET `/guest/bookings/create/{room}` → menampilkan form
    -   POST `/guest/bookings` → menyimpan booking

---

## 🔧 CARA KERJA TAMBAH BOOKING

### A. FLOW DIAGRAM

```
Guest Lihat Daftar Kamar
         ↓
Guest Klik Kamar yang Ingin Dipesan
         ↓
GET /guest/bookings/create/{room_id}
         ↓
BookingController::create($room)
         ↓
Tampilkan Form Booking (booking_create.blade.php)
         ↓
Tampilkan Info Kamar & Hitung Total Harga Real-time
         ↓
Guest Isi Form & Klik "Lanjutkan Pemesanan"
         ↓
POST /guest/bookings (dengan data booking)
         ↓
BookingController::store() - Validasi Data
         ↓
Jika INVALID → Kembali ke form dengan error
         ↓
Jika VALID → Buat Booking & BookingItem
         ↓
Redirect ke halaman Terima Kasih
```

---

## 📝 CODE PENJELASAN - TAMBAH BOOKING

### A. METHOD `create($room)` - TAMPILKAN FORM

```php
public function create(Room $room)
{
    return view('guest.booking_create', ['room' => $room]);
}
```

**Penjelasan:**

-   `Room $room` = Laravel Route Model Binding
    -   Otomatis ambil kamar dari database berdasarkan ID di URL
    -   Jika kamar tidak ditemukan → error 404
-   `['room' => $room]` = kirim data kamar ke view
    -   Di view bisa akses dengan `$room->name`, `$room->price`, dll

---

### B. METHOD `store($request)` - SIMPAN BOOKING

```php
public function store(Request $request)
{
    // LANGKAH 1: VALIDASI
    $data = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'nullable|email|max:255',
        'guest_phone' => 'nullable|string|max:50',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'qty' => 'nullable|integer|min:1',
    ]);
```

**Penjelasan Validasi:**

| Rule              | Arti                                                  |
| ----------------- | ----------------------------------------------------- |
| `required`        | Wajib diisi                                           |
| `exists:rooms,id` | Room ID harus ada di tabel rooms (cegah kamar fiktif) |
| `string`          | Harus teks                                            |
| `max:255`         | Maximum 255 karakter                                  |
| `nullable`        | Boleh kosong                                          |
| `email`           | Harus format email valid                              |
| `date`            | Harus tanggal valid                                   |
| `after:check_in`  | Check-out harus SETELAH check-in                      |
| `integer`         | Harus bilangan bulat                                  |

---

```php
    // LANGKAH 2: AMBIL DATA KAMAR
    $room = Room::findOrFail($data['room_id']);

    // LANGKAH 3: HITUNG JUMLAH MALAM
    $nights = (new \DateTime($data['check_in']))
        ->diff(new \DateTime($data['check_out']))
        ->days;

    $qty = $data['qty'] ?? 1;  // Default 1 kamar jika kosong

    // LANGKAH 4: HITUNG SUBTOTAL
    $subtotal = $room->price_per_night * $nights * $qty;
```

**Penjelasan Perhitungan:**

```
Hitung Malam:
- DateTime::diff() = perbedaan tanggal
- ->days = ambil jumlah hari
- Contoh: 2026-01-04 sampai 2026-01-06 = 2 malam

Hitung Total:
subtotal = Harga Per Malam × Jumlah Malam × Jumlah Kamar
```

---

```php
    // LANGKAH 5: BUAT BOOKING DI TABEL BOOKINGS
    $booking = Booking::create([
        'booking_code' => strtoupper(Str::random(8)),  // Kode unik: A7K2M9X1
        'guest_name' => $data['guest_name'],
        'guest_email' => $data['guest_email'] ?? null,
        'guest_phone' => $data['guest_phone'] ?? null,
        'check_in' => $data['check_in'],
        'check_out' => $data['check_out'],
        'nights' => $nights,
        'total_price' => $subtotal,
        'payment_status' => 'pending',          // Status: pending → belum bayar
        'expires_at' => now()->addDay(),        // Booking berlaku 1 hari
    ]);
```

**Penjelasan:**

| Field                        | Arti                                       |
| ---------------------------- | ------------------------------------------ |
| `booking_code`               | Kode unik untuk booking (contoh: A7K2M9X1) |
| `strtoupper(Str::random(8))` | Generate 8 karakter random UPPERCASE       |
| `guest_name`                 | Nama tamu                                  |
| `guest_email`                | Email tamu (opsional)                      |
| `check_in`                   | Tanggal check-in                           |
| `check_out`                  | Tanggal check-out                          |
| `nights`                     | Jumlah malam                               |
| `total_price`                | Total harga yang harus dibayar             |
| `payment_status`             | Status pembayaran (pending/paid)           |
| `expires_at`                 | Kapan booking kadaluarsa                   |

---

```php
    // LANGKAH 6: BUAT BOOKING ITEM (RELASI BOOKING ← KAMAR)
    BookingItem::create([
        'booking_id' => $booking->id,            // Link ke booking
        'room_id' => $room->id,                  // Room mana yang dipesan
        'price_per_night' => $room->price_per_night,
        'qty' => $qty,                           // Jumlah kamar
        'subtotal' => $subtotal,                 // Total harga
    ]);

    // LANGKAH 7: REDIRECT KE HALAMAN TERIMA KASIH
    return redirect()->route('guest.booking.thanks', $booking->id);
}
```

**Penjelasan:**

| Tabel           | Fungsi                                                               |
| --------------- | -------------------------------------------------------------------- |
| `bookings`      | Menyimpan data booking utama (nama, email, tanggal, harga)           |
| `booking_items` | Menyimpan detail kamar yang dipesan (relasi 1 booking → banyak item) |

**Satu Booking Bisa Memiliki Banyak Kamar:**

```
Booking A (Rp 5.000.000)
├─ BookingItem 1: Kamar 101 (2 malam)
├─ BookingItem 2: Kamar 102 (2 malam)
└─ BookingItem 3: Kamar 103 (1 malam)
```

---

## 3️⃣ STRUKTUR DATABASE

### Tabel `rooms`

```
id             | INT (Primary Key)
name           | VARCHAR (Nama kamar)
type           | VARCHAR (Tipe: Single, Double, Suite)
price_per_night| INT (Harga per malam)
capacity       | INT (Jumlah tamu)
description    | TEXT (Deskripsi)
is_active      | BOOLEAN (Tersedia/Tidak)
created_at     | TIMESTAMP
updated_at     | TIMESTAMP
```

### Tabel `bookings`

```
id              | INT (Primary Key)
booking_code    | VARCHAR (Kode unik)
guest_name      | VARCHAR (Nama tamu)
guest_email     | VARCHAR
guest_phone     | VARCHAR
check_in        | DATE
check_out       | DATE
nights          | INT
total_price     | INT
payment_status  | VARCHAR (pending/paid)
expires_at      | TIMESTAMP
created_at      | TIMESTAMP
updated_at      | TIMESTAMP
```

### Tabel `booking_items`

```
id              | INT (Primary Key)
booking_id      | INT (Foreign Key → bookings)
room_id         | INT (Foreign Key → rooms)
price_per_night | INT
qty             | INT
subtotal        | INT
created_at      | TIMESTAMP
updated_at      | TIMESTAMP
```

---

## 🎯 TESTING

### Test 1: Tambah Kamar (Admin)

```
1. Login dengan akun admin
2. Klik "Admin Dashboard"
3. Klik "Daftar Kamar"
4. Klik tombol hijau "➕ Tambah Kamar"
5. Isi form:
   - Nomor Kamar: 301
   - Harga: 750000
   - Kapasitas: 4
   - Deskripsi: Kamar luas dengan balkon
   - Centang: Kamar Aktif
6. Klik "Simpan Kamar"
Expected: ✓ Redirect ke daftar kamar dengan pesan sukses
Expected: ✓ Kamar baru muncul di tabel
```

### Test 2: Tambah Booking (Guest)

```
1. Jangan login (akses sebagai guest)
2. Klik "Daftar Kamar"
3. Klik salah satu kamar
4. Isi form booking:
   - Nama: Ahmad Ridho
   - Email: ahmad@email.com
   - HP: 08123456789
   - Check-in: 2026-01-10
   - Check-out: 2026-01-12
   - Kamar: 1
5. Lihat ringkasan otomatis:
   - Harga Per Malam: Rp XXX
   - Jumlah Malam: 2
   - Total: Rp XXX × 2 × 1
6. Klik "Lanjutkan Pemesanan"
Expected: ✓ Data tersimpan
Expected: ✓ Redirect ke halaman terima kasih
Expected: ✓ Tampilkan booking code
```

---

## 🔍 DEBUGGING

### Error: "Nomor Kamar Sudah Ada"

```
Penyebab: Nomor kamar duplikat
Solusi: Gunakan nomor kamar yang belum ada
```

### Error: "Check-out Harus Setelah Check-in"

```
Penyebab: Check-out date lebih awal dari check-in
Solusi: Pastikan check-out setelah check-in minimal 1 hari
```

### Error: "Kolom Wajib Diisi"

```
Penyebab: Ada field yang kosong
Solusi: Isi semua field yang ditandai dengan * (bintang)
```

---

## 💡 TIPS

✓ **Admin:**

-   Cek nomor kamar sebelum menambah (jangan duplikat)
-   Harga harus realistis dan sesuai standar hotel
-   Centang "Kamar Aktif" agar bisa dipesan

✓ **Guest:**

-   Isi email untuk menerima konfirmasi booking
-   Check-out harus minimal 1 hari setelah check-in
-   Harga real-time otomatis dihitung saat pilih tanggal

---

**Selesai! Sekarang sistem hotel Anda sudah punya fitur tambah kamar & booking! 🎉**
