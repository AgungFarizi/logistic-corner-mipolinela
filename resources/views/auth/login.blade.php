<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Logistic Corner</title>
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
            background: linear-gradient(135deg, #DC2626 0%, #1D4ED8 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #B91C1C 0%, #1E40AF 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(220, 38, 38, 0.3);
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
        
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }
        
        .decorative-circle {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(29, 78, 216, 0.3));
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-pattern p-4 relative">
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-red-900/70 via-blue-900/70 to-slate-900/80"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Circles -->
        <div class="absolute top-10 left-10 w-72 h-72 decorative-circle rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 decorative-circle rounded-full blur-3xl animate-float-delay"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-2xl animate-pulse-slow"></div>
        
        <!-- Floating Icons -->
        <div class="absolute top-20 right-20 text-white/20 text-6xl animate-float">
            <i class="fas fa-box"></i>
        </div>
        <div class="absolute bottom-32 left-20 text-white/20 text-5xl animate-float-delay">
            <i class="fas fa-truck"></i>
        </div>
        <div class="absolute top-1/3 right-1/4 text-white/10 text-4xl animate-float">
            <i class="fas fa-warehouse"></i>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md">
        
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-500 via-white to-blue-600 rounded-3xl shadow-2xl mb-4 p-1">
                <div class="w-full h-full bg-white rounded-2xl flex items-center justify-center">
                     <img src="images/logo.png" class="w-15 h-15  object-cover" alt="Logo">
                </div>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">
                Logistic Corner<span class="text-red-600"> Polinela</span> 
            </h1>
            <p class="text-blue-200 text-sm">Sistem Manajemen Paket Dengan Fitur Notif Otomatis</p>
        </div>
        
        <!-- Login Card -->
        <div class="glass-card rounded-3xl shadow-2xl p-8 border-t-4 border-red-500">
            
           <!-- Header -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <img src="images/hello.png" class="w-10 h-10 object-cover" alt="Logo">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Admin</h2>
                <p class="text-gray-500 text-sm mt-1">Silahkan Login ke dashboard admin</p>
            </div>
        </div>

            
            <!-- Alert Messages -->
            @if($errors->has('login'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    <span>{{ $errors->first('login') }}</span>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            <!-- Login Form -->
            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-blue-600 mr-2"></i>Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" 
                               class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white" 
                               placeholder="Masukkan username Anda" required>
                    </div>
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-red-600 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password"
                               class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-gray-50 focus:bg-white" 
                               placeholder="Masukkan password Anda" required>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-blue-600 transition" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-semibold text-lg shadow-lg flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>
            
            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 underline decoration-2 underline-offset-2">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white/60 text-sm">
                <i class="fas fa-shield-halved mr-1"></i>
                PUM - D3 Manajamen Informatika
            </p>
            <p class="text-white/40 text-xs mt-2">
                © 2025 Logistic Corner Polinela.
            </p>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>