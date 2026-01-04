<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ========================
    // 1. TAMPILKAN HALAMAN LOGIN
    // ========================
    /**
     * Fungsi ini menampilkan halaman login
     * Ketika user mengakses /login, akan menampilkan form login
     */
    public function showLogin()
    {
        // Jika user sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    // ==========================
    // 2. PROSES LOGIN (VERIFIKASI)
    // ==========================
    /**
     * Fungsi ini memproses login dari form
     * - Validasi email dan password
     * - Cek di database
     * - Jika cocok, buat session
     * - Jika tidak cocok, kembalikan ke login dengan error
     */
    public function login(Request $request)
    {
        // LANGKAH 1: VALIDASI DATA DARI FORM
        // Memastikan email dan password tidak kosong dan formatnya benar
        $validated = $request->validate([
            'email' => 'required|email',  // email harus ada dan format valid
            'password' => 'required|min:6', // password harus ada min 6 karakter
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // LANGKAH 2: CEK KREDENSIAL
        // Auth::attempt() = cek apakah email dan password cocok di database
        // 'remember' = centang "Remember me" agar tetap login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->boolean('remember'))) {
            // LANGKAH 3: JIKA LOGIN BERHASIL
            // Buat ulang session untuk keamanan
            $request->session()->regenerate();
            
            // Arahkan ke dashboard admin
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Admin Panel!');
        }

        // LANGKAH 4: JIKA LOGIN GAGAL
        // Kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    // ==========================
    // 3. LOGOUT (KELUAR)
    // ==========================
    /**
     * Fungsi ini untuk keluar/logout
     * - Hapus session
     * - Arahkan ke halaman utama
     */
    public function logout(Request $request)
    {
        // LANGKAH 1: HAPUS AUTENTIKASI PENGGUNA
        Auth::logout();

        // LANGKAH 2: HAPUS SESSION
        $request->session()->invalidate();

        // LANGKAH 3: REGENERATE TOKEN CSRF
        // Ini untuk keamanan mencegah CSRF attack
        $request->session()->regenerateToken();

        // LANGKAH 4: ARAHKAN KE HALAMAN UTAMA
        return redirect('/')->with('success', 'Anda telah logout');
    }

    // ==========================
    // 4. TAMPILKAN HALAMAN REGISTER
    // ==========================
    /**
     * Fungsi ini menampilkan halaman registrasi user baru
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.register');
    }

    // ==========================
    // 5. PROSES REGISTRASI
    // ==========================
    /**
     * Fungsi ini memproses pendaftaran user baru
     * - Validasi data
     * - Cek apakah email sudah ada
     * - Buat user baru
     * - Arahkan ke login
     */
    public function register(Request $request)
    {
        // LANGKAH 1: VALIDASI DATA REGISTRASI
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // nama max 255 karakter
            'email' => 'required|email|unique:users', // email harus unik (tidak ada yang sama)
            'password' => 'required|min:6|confirmed', // confirmed = password dan password_confirmation harus sama
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // LANGKAH 2: BUAT USER BARU
        // Hash password = enkripsi password agar aman di database
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Enkripsi password
        ]);

        // LANGKAH 3: ARAHKAN KE LOGIN
        return redirect()->route('auth.showLogin')->with('success', 'Registrasi berhasil! Silakan login');
    }
}
