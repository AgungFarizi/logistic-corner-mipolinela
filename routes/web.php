<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\DendaController;


// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Route untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Ganti Password
    Route::get('/ganti-password', [AuthController::class, 'showGantiPassword'])->name('ganti-password');
    Route::post('/ganti-password', [AuthController::class, 'gantiPassword'])->name('ganti-password.process');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Paket CRUD
    Route::resource('paket', PaketController::class);
    
    // Aksi tambahan untuk paket
    Route::post('/paket/{paket}/ambil', [PaketController::class, 'ambilPaket'])->name('paket.ambil');
    Route::get('/paket/{paket}/notifikasi', [PaketController::class, 'kirimNotifikasiWA'])->name('paket.notifikasi');
    Route::get('/paket/{paket}/reminder', [PaketController::class, 'kirimReminder'])->name('paket.reminder');
    
    // Tracking
    Route::get('/tracking', [PaketController::class, 'tracking'])->name('tracking');

    // Denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda');
    Route::post('/denda/hitung-ulang', [DendaController::class, 'hitungUlang'])->name('denda.hitung-ulang');

    // Export
    Route::get('/export', [ExportController::class, 'index'])->name('export');
    Route::post('/export/harian', [ExportController::class, 'exportHarian'])->name('export.harian');
    Route::post('/export/bulanan', [ExportController::class, 'exportBulanan'])->name('export.bulanan');
    Route::post('/export/tahunan', [ExportController::class, 'exportTahunan'])->name('export.tahunan');
    Route::get('/export/semua', [ExportController::class, 'exportSemua'])->name('export.semua');

    // STATISTIK
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
    Route::get('/api/statistik/realtime', [StatistikController::class, 'getRealtimeData'])->name('statistik.realtime');
});