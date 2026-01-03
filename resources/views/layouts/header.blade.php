<header class="bg-white shadow-sm sticky top-0 z-40 px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                @yield('page-title', 'Dashboard')
            </h2>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
        
        <div class="flex items-center">
            <!-- User Info -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">
                        {{ Auth::user()->nama_lengkap }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>
