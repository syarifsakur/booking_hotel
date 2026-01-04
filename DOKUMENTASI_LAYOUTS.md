# 📐 LAYOUTS DOCUMENTATION

## 📍 Master Layout Location

**File:** `resources/views/layouts/app.blade.php`

---

## 🎨 Layout Structure

```
┌─────────────────────────────────────────────────┐
│            NAVBAR (Sticky Top)                   │
│  • Logo + Brand Name                             │
│  • Navigation Links                              │
│  • Login/Logout Buttons                          │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│         ALERT/MESSAGE AREA (Optional)            │
│  • Success Messages (Green)                      │
│  • Error Messages (Red)                          │
│  • Validation Errors                             │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│                                                  │
│     @yield('content')                            │
│     ↓                                            │
│     Page-specific content here                   │
│                                                  │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│              FOOTER                              │
│  • About Section                                 │
│  • Links                                         │
│  • Contact Info                                  │
│  • Copyright                                     │
└─────────────────────────────────────────────────┘
```

---

## 🔧 Cara Menggunakan Layout

### Di View File:

```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    <!-- Konten halaman Anda di sini -->
@endsection
```

### Dengan Custom Styles:

```blade
@extends('layouts.app')

@section('title', 'Halaman dengan CSS')

@section('styles')
    <style>
        /* CSS custom di sini */
    </style>
@endsection

@section('content')
    <!-- Konten -->
@endsection
```

### Dengan Custom Scripts:

```blade
@extends('layouts.app')

@section('content')
    <!-- Konten -->
@endsection

@section('scripts')
    <script>
        // JavaScript custom di sini
    </script>
@endsection
```

---

## 📋 Features

### 1. Navigation Bar (Sticky)

-   **Logo & Brand:** Clickable, redirect ke home
-   **Auth Check:** Tampil berbeda untuk user login vs guest
-   **User Menu:**
    -   Admin: Tombol link ke dashboard admin
    -   Guest: Login/Register buttons
-   **Logout:** Form-based POST untuk security

### 2. Alert System

**Success Alert:**

```blade
{{ session('success') }}
```

✅ Green box dengan pesan sukses

**Error Alert:**

```blade
{{ session('error') }}
```

❌ Red box dengan pesan error

**Validation Errors:**

```blade
{{ $errors->all() }}
```

❌ List semua validation errors

### 3. Content Area

-   Full-width responsive
-   Max-width untuk readability
-   Padding untuk spacing

### 4. Footer

-   Contact information
-   Quick links
-   Operating hours
-   Copyright notice

---

## 🎯 Pages Using This Layout

| Page         | File                           | Route                           |
| ------------ | ------------------------------ | ------------------------------- |
| Tambah Kamar | admin/rooms/create.blade.php   | GET /admin/rooms/create         |
| Booking Form | guest/booking_create.blade.php | GET /guest/bookings/create/{id} |
| Thanks Page  | guest/booking_thanks.blade.php | GET /guest/bookings/thanks/{id} |

---

## 🔐 Authentication Features

### Navbar shows different items based on auth:

**If Authenticated (`@auth`):**

```blade
📊 Admin Dashboard Link
🚪 Logout Button
```

**If Not Authenticated (`@guest`):**

```blade
Login Link
Daftar (Register) Button
```

---

## 🎨 Styling

-   **Framework:** Tailwind CSS (via CDN)
-   **Font:** Segoe UI (System fonts)
-   **Colors:**
    -   Primary: Blue (Blue-500, Blue-600)
    -   Success: Green (Green-50, Green-200)
    -   Error: Red (Red-50, Red-200, Red-500)
    -   Neutral: Slate (Slate-50 to Slate-900)

---

## 📱 Responsive Design

-   **Mobile-first** approach
-   **Grid Layout** untuk footer
-   **Flex Layout** untuk navbar
-   **Max-width** untuk desktop readability

---

## 🔗 Navigation Routes

Used in layout:

-   `route('dashboard')` - Homepage
-   `route('admin.dashboard')` - Admin dashboard
-   `route('auth.showLogin')` - Login page
-   `route('auth.showRegister')` - Register page
-   `route('auth.logout')` - Logout action
-   `route('room.list')` - Room listing
-   `route('about')` - About page

---

## 📝 Title Section

Set custom title per page:

```blade
@section('title', 'Nama Halaman')
```

Default: "Hotel Booking System"

---

## 🧹 Sections Available

```blade
@section('title')          <!-- Page title -->
@section('styles')         <!-- Custom CSS -->
@section('content')        <!-- Main content (REQUIRED) -->
@section('scripts')        <!-- Custom JS -->
```

---

## ✅ Validation

Layout menampilkan validation errors otomatis:

```php
@if ($errors->any())
    <!-- Error messages box -->
@endif
```

Dari Blade:

```blade
@error('field_name')
    <p>{{ $message }}</p>
@enderror
```

---

**Layout siap digunakan untuk semua halaman! 🎉**
