<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Logistic Corner</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="/images/logo_logistic-bck.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        .bg-pattern {
            background-image: 
                url('/images/bck.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #DC2626 0%, #1D4ED8 50%, #DC2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #1D4ED8 0%, #DC2626 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #1E40AF 0%, #B91C1C 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(29, 78, 216, 0.3);
        }
        
        .input-focus:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-delay {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .decorative-circle {
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.3), rgba(220, 38, 38, 0.3));
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-pattern p-4 relative">
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 via-red-900/50 to-slate-900/80"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-10 w-72 h-72 decorative-circle rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 decorative-circle rounded-full blur-3xl animate-float-delay"></div>
        
        <!-- Floating Icons -->
        <div class="absolute top-20 left-20 text-white/20 text-6xl animate-float">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="absolute bottom-32 right-20 text-white/20 text-5xl animate-float-delay">
            <i class="fas fa-id-card"></i>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md">
        
        <!-- Logo Section -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 via-white to-red-500 rounded-2xl shadow-2xl mb-3 p-1">
                <div class="w-full h-full bg-white rounded-xl flex items-center justify-center">
                    <img src="images/logo.png" class="w-15 h-15  object-cover" alt="Logo">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-1">
                Logistic Corner <span class="text-red-600">Polinela</span>
            </h1>
            <p class="text-blue-200 text-sm">Daftar Akun Admin Baru</p>
        </div>
        
        <!-- Register Card -->
        <div class="glass-card rounded-3xl shadow-2xl p-6 border-t-4 border-blue-500">
            
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="text-xl font-bold text-gray-800">Buat Akun Baru 📝</h2>
                <p class="text-gray-500 text-sm">Isi data untuk mendaftar</p>
            </div>
            
            <!-- Register Form -->
            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-user text-blue-600 mr-1"></i>Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-badge text-gray-400"></i>
                        </div>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white @error('nama_lengkap') border-red-500 @enderror" 
                               placeholder="Masukkan nama lengkap" required>
                    </div>
                    @error('nama_lengkap')<p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
                
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-at text-red-600 mr-1"></i>Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-gray-400"></i>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white @error('username') border-red-500 @enderror" 
                               placeholder="Pilih username unik" required>
                    </div>
                    @error('username')<p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="fas fa-envelope text-blue-600 mr-1"></i>Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white @error('email') border-red-500 @enderror" 
                               placeholder="contoh@email.com" required>
                    </div>
                    @error('email')<p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
                
                <!-- Password -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-lock text-red-600 mr-1"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white @error('password') border-red-500 @enderror" 
                                   placeholder="Min 8 karakter" required>
                        </div>
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-check-double text-blue-600 mr-1"></i>Konfirmasi
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white" 
                                   placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>
                
                <!-- Terms -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" required
                           class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Saya menyetujui <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-red-600 hover:underline">Kebijakan Privasi</a>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-semibold text-lg shadow-lg flex items-center justify-center space-x-2">
                <i class="fas fa-user-plus"></i>
                <span>Daftar Sekarang</span>
            </button>

            </form>
            
            <!-- Divider -->
            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">sudah punya akun?</span>
                </div>
            </div>
            
            <!-- Login Link -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full py-3 border-2 border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 hover:border-blue-300 transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2 text-blue-600"></i>
                    Masuk ke Akun
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-4">
            <p class="text-white/60 text-sm">
                <i class="fas fa-shield-halved mr-1"></i>
                PUM - D3 Manajemen Informatika
            </p>
        </div>
    </div>
</body>
</html>