<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white shadow-2xl z-50">
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center space-x-3">
            <div class="w-14 h-14 rounded-full overflow-hidden bg-white shadow-lg flex items-center justify-center p-1">
    <img src="{{ asset('images/logo.png') }}" 
            alt="Logo" 
            class="w-full h-full object-contain">
    </div>
            <div>
                <h1 class="font-bold text-lg">Logistic Corner</h1>
                <p class="text-xs text-amber-400">Politeknik Negeri Lampung</p>
            </div>
        </div>
    </div>
    
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}" 
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-chart-pie w-5"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('paket.create') }}" 
           class="sidebar-link {{ request()->routeIs('paket.create') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-plus-circle w-5"></i>
            <span>Input Paket</span>
        </a>
        
        <a href="{{ route('paket.index') }}" 
           class="sidebar-link {{ request()->routeIs('paket.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-list w-5"></i>
            <span>Daftar Paket</span>
        </a>
        
        <a href="{{ route('tracking') }}" 
           class="sidebar-link {{ request()->routeIs('tracking') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-search-location w-5"></i>
            <span>Tracking Paket</span>
        </a>
        
        <a href="{{ route('denda') }}" 
           class="sidebar-link {{ request()->routeIs('denda') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-exclamation-triangle w-5"></i>
            <span>Denda & Telat</span>
        </a>
        
        <a href="{{ route('export') }}" class="sidebar-link {{ request()->routeIs('export') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-file-excel w-5"></i>
            <span>Ekspor Laporan</span>
        </a>
        
        <a href="{{ route('statistik') }}" class="sidebar-link {{ request()->routeIs('statistik') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-xl transition hover:bg-slate-700">
            <i class="fas fa-chart-bar w-5"></i>
            <span>Statistik</span>
        </a>
    </nav>
    
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>