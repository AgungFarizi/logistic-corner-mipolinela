<?php
// File: app/Http/Controllers/ExportController.php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Exports\PaketExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    // Export harian
    public function exportHarian(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $tanggal = $request->tanggal;
        $filename = 'Laporan_Paket_' . $tanggal . '.xlsx';

        return Excel::download(new PaketExport('harian', $tanggal), $filename);
    }

    // Export bulanan
    public function exportBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required'
        ]);

        $bulan = $request->bulan; // format: 2024-01
        $filename = 'Laporan_Paket_' . $bulan . '.xlsx';

        return Excel::download(new PaketExport('bulanan', $bulan), $filename);
    }

    // Export tahunan
    public function exportTahunan(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer'
        ]);

        $tahun = $request->tahun;
        $filename = 'Laporan_Paket_Tahun_' . $tahun . '.xlsx';

        return Excel::download(new PaketExport('tahunan', $tahun), $filename);
    }

    // Export semua
    public function exportSemua()
    {
        $filename = 'Laporan_Paket_Lengkap_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PaketExport('semua'), $filename);
    }
}