<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Hotel Pantai Indah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center min-h-screen p-4">
    
    <div class="w-full max-w-md">
        <!-- LOGO & JUDUL -->
        <div class="text-center mb-8">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-emerald-500 text-white shadow-lg mb-4">
                <span class="text-2xl font-bold">H</span>
            </div>
            <h1 class="text-3xl font-bold text-emerald-900">Hotel Pantai Indah</h1>
            <p class="text-emerald-600 mt-2">Buat Akun Admin</p>
        </div>

        <!-- FORM REGISTRASI -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <!-- PESAN ERROR (jika ada) -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="font-semibold mb-2">❌ Registrasi Gagal!</div>
                    @foreach ($errors->all() as $error)
                        <div class="text-sm">• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('auth.register') }}" class="space-y-4">
                @csrf

                <!-- NAMA INPUT -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        👤 Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama Anda"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        required
                    >
                </div>

                <!-- EMAIL INPUT -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        📧 Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        required
                    >
                </div>

                <!-- PASSWORD INPUT -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        🔒 Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        required
                    >
                    <p class="text-xs text-slate-500 mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal</p>
                </div>

                <!-- KONFIRMASI PASSWORD INPUT -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                        🔒 Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        placeholder="Ulangi password"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        required
                    >
                </div>

                <!-- TOMBOL DAFTAR -->
                <button 
                    type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-lg transition duration-200 mt-6"
                >
                    ✓ Daftar Akun
                </button>
            </form>

            <!-- SEPARATOR -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-slate-200"></div>
                <span class="text-slate-400 text-sm px-3">atau</span>
                <div class="flex-1 border-t border-slate-200"></div>
            </div>

            <!-- LINK LOGIN -->
            <div class="text-center">
                <p class="text-slate-600 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('auth.showLogin') }}" class="text-emerald-500 font-semibold hover:text-emerald-600">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
