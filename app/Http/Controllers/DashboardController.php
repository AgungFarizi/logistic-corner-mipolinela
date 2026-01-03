<?php
// File: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Rak;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalPaket = Paket::count();
        $paketDiambil = Paket::where('status', 'diambil')->count();
        $paketMenunggu = Paket::where('status', 'menunggu')->count();
        $paketTelat = Paket::telat()->count();
        
        // Total denda
        $totalDenda = Paket::where('status', 'menunggu')
                          ->where('batas_pengambilan', '<', Carbon::today())
                          ->get()
                          ->sum(function ($paket) {
                              return $paket->denda_otomatis;
                          });
        
        $totalDenda += Paket::where('status', 'diambil')->sum('denda');

        // Paket terbaru
        $paketTerbaru = Paket::with('admin')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Data untuk grafik bulanan
        $dataBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulanan[] = Paket::whereMonth('tanggal_masuk', $i)
                                  ->whereYear('tanggal_masuk', date('Y'))
                                  ->count();
        }

        // Data untuk grafik status
        $dataStatus = [
            'diambil' => $paketDiambil,
            'menunggu' => $paketMenunggu - $paketTelat,
            'telat' => $paketTelat,
        ];

        return view('dashboard.index', compact(
            'totalPaket',
            'paketDiambil',
            'paketMenunggu',
            'paketTelat',
            'totalDenda',
            'paketTerbaru',
            'dataBulanan',
            'dataStatus'
        ));
    }
}