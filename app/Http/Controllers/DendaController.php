<?php
// File: app/Http/Controllers/DendaController.php

namespace App\Http\Controllers;

use App\Models\Paket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $paketTelat = Paket::with('admin')
                          ->where('status', 'menunggu')
                          ->where('batas_pengambilan', '<', Carbon::today())
                          ->orderBy('batas_pengambilan', 'asc')
                          ->paginate(10);

        $totalDenda = 0;
        foreach ($paketTelat as $paket) {
            $totalDenda += $paket->denda_otomatis;
        }

        return view('denda.index', compact('paketTelat', 'totalDenda'));
    }

    // Hitung ulang semua denda
    public function hitungUlang()
    {
        $paketTelat = Paket::where('status', 'menunggu')
                          ->where('batas_pengambilan', '<', Carbon::today())
                          ->get();

        foreach ($paketTelat as $paket) {
            $hariTelat = Carbon::today()->diffInDays($paket->batas_pengambilan);
            $paket->update([
                'hari_telat' => $hariTelat,
                'denda' => $hariTelat * 1000
            ]);
        }

        return redirect()->back()
                         ->with('success', 'Denda berhasil dihitung ulang untuk ' . $paketTelat->count() . ' paket');
    }
}