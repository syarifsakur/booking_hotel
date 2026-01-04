<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RoomListController;
use App\Http\Controllers\RoomDetailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Guest\QrController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/guest/bookings/create/{room}', [BookingController::class, 'create'])->name('guest.booking.create');
Route::post('/guest/bookings', [BookingController::class, 'store'])->name('guest.booking.store');
Route::get('/guest/bookings/thanks/{booking}', [BookingController::class, 'thanks'])->name('guest.booking.thanks');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
route::get('/room', [App\Http\Controllers\RoomListController::class, 'index'])->name('room.list');
route::get('/room/{id}', [App\Http\Controllers\RoomDetailController::class, 'show'])->name('room.detail');


Route::get('/qr/{token}', [QrController::class, 'show'])->name('qr.show');



// ==============================
// RUTE AUTHENTICATION (LOGIN/LOGOUT)
// ==============================
// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.showLogin');
// Proses Login
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Halaman Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
// Proses Register
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// ==============================
// RUTE ADMIN (PERLU LOGIN)
// ==============================
// Semua rute di bawah protected dengan middleware 'auth'
// Artinya hanya yang sudah login bisa akses
Route::middleware('auth')->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola Kamar
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/rooms/create', [AdminController::class, 'createRoom'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    
    // Kelola Booking
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    
    // Kelola User
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    
    // Logout (hanya bisa diakses jika sudah login)
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});