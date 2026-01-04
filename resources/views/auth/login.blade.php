<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel Pantai Indah</title>
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
            <p class="text-emerald-600 mt-2">Admin Panel Login</p>
        </div>

        <!-- FORM LOGIN -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <!-- PESAN ERROR (jika ada) -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="font-semibold mb-2">❌ Login Gagal!</div>
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- PESAN SUKSES (jika ada) -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="font-semibold">✓ {{ session('success') }}</div>
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                @csrf {{-- Token keamanan Laravel --}}

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
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        required
                    >
                </div>

                <!-- REMEMBER ME CHECKBOX -->
                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember"
                        class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500"
                    >
                    <label for="remember" class="text-sm text-slate-600">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- TOMBOL LOGIN -->
                <button 
                    type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-lg transition duration-200 mt-6"
                >
                    🚀 Masuk
                </button>
            </form>

            <!-- SEPARATOR -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-slate-200"></div>
                <span class="text-slate-400 text-sm px-3">atau</span>
                <div class="flex-1 border-t border-slate-200"></div>
            </div>

            <!-- LINK REGISTER -->
            <div class="text-center">
                <p class="text-slate-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('auth.showRegister') }}" class="text-emerald-500 font-semibold hover:text-emerald-600">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- INFO DEMO (opsional) -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
            <p class="text-sm text-blue-700">
                <strong>Demo:</strong> Gunakan akun yang sudah terdaftar di database
            </p>
        </div>
    </div>

</body>
</html>
