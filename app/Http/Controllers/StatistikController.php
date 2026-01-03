<?php
namespace App\Http\Controllers;
use App\Models\Paket;
use App\Models\Rak;
use App\Models\User;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StatistikController extends Controller
{
    /**
     * Halaman utama statistik
     */
    public function index()
    {
        // ==========================================
        // STATISTIK UMUM
        // ==========================================
        $totalPaket = Paket::count();
        $paketDiambil = Paket::where('status', 'diambil')->count();
        $paketMenunggu = Paket::where('status', 'menunggu')->count();
        $paketTelat = Paket::telat()->count();
        
        // Persentase
        $persenDiambil = $totalPaket > 0 ? round(($paketDiambil / $totalPaket) * 100, 1) : 0;
        $persenMenunggu = $totalPaket > 0 ? round(($paketMenunggu / $totalPaket) * 100, 1) : 0;
        $persenTelat = $paketMenunggu > 0 ? round(($paketTelat / $paketMenunggu) * 100, 1) : 0;
        // ==========================================
        // STATISTIK DENDA
        // ==========================================
        $totalDendaTerkumpul = Paket::where('status', 'diambil')->sum('denda');
        $totalDendaBelumBayar = Paket::where('status', 'menunggu')
                                     ->where('batas_pengambilan', '<', Carbon::today())
                                     ->get()
                                     ->sum(function ($p) {
                                         return $p->denda_otomatis;
                                     });
        $totalDenda = $totalDendaTerkumpul + $totalDendaBelumBayar;
        // ==========================================
        // STATISTIK PER EKSPEDISI
        // ==========================================
        $perEkspedisi = Paket::select('ekspedisi', DB::raw('count(*) as total'))
                             ->groupBy('ekspedisi')
                             ->orderBy('total', 'desc')
                             ->get();
        // ==========================================
        // STATISTIK PER RAK
        // ==========================================
        $perRak = Paket::select('rak', DB::raw('count(*) as total'))
                       ->where('status', 'menunggu')
                       ->groupBy('rak')
                       ->orderBy('rak')
                       ->get();
        $kapasitasRak = Rak::all();
        // ==========================================
        // STATISTIK BULANAN (12 bulan terakhir)
        // ==========================================
        $dataBulanan = [];
        $labelBulanan = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labelBulanan[] = $bulan->translatedFormat('M Y');
            $dataBulanan['masuk'][] = Paket::whereMonth('tanggal_masuk', $bulan->month)
                                           ->whereYear('tanggal_masuk', $bulan->year)
                                           ->count();
            $dataBulanan['diambil'][] = Paket::whereMonth('tanggal_diambil', $bulan->month)
                                             ->whereYear('tanggal_diambil', $bulan->year)
                                             ->where('status', 'diambil')
                                             ->count();
        }
        // ==========================================
        // STATISTIK MINGGUAN (7 hari terakhir)
        // ==========================================
        $dataMingguan = [];
        $labelMingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $labelMingguan[] = $tanggal->translatedFormat('D, d M');
            $dataMingguan['masuk'][] = Paket::whereDate('tanggal_masuk', $tanggal)->count();
            $dataMingguan['diambil'][] = Paket::whereDate('tanggal_diambil', $tanggal)
                                              ->where('status', 'diambil')
                                              ->count();
        }
        // ==========================================
        // TOP 10 PENERIMA PAKET
        // ==========================================
        $topPenerima = Paket::select('nama_penerima', 'no_whatsapp', DB::raw('count(*) as total_paket'))
                            ->groupBy('nama_penerima', 'no_whatsapp')
                            ->orderBy('total_paket', 'desc')
                            ->take(10)
                            ->get();
        // ==========================================
        // RATA-RATA WAKTU PENGAMBILAN
        // ==========================================
        $avgWaktuAmbil = Paket::where('status', 'diambil')
                              ->whereNotNull('tanggal_diambil')
                              ->get()
                              ->avg(function ($p) {
                                  return Carbon::parse($p->tanggal_masuk)->diffInDays($p->tanggal_diambil);
                              });
        $avgWaktuAmbil = round($avgWaktuAmbil ?? 0, 1);
        // ==========================================
        // STATISTIK BERAT PAKET
        // ==========================================
        $totalBerat = Paket::sum('berat');
        $avgBerat = Paket::avg('berat');
        $maxBerat = Paket::max('berat');
        $minBerat = Paket::min('berat');
        // ==========================================
        // STATISTIK HARI INI
        // ==========================================
        $hariIni = [
            'masuk' => Paket::whereDate('tanggal_masuk', Carbon::today())->count(),
            'diambil' => Paket::whereDate('tanggal_diambil', Carbon::today())->where('status', 'diambil')->count(),
            'telat' => Paket::telat()->count(),
        ];
        // ==========================================
        // STATISTIK BULAN INI
        // ==========================================
        $bulanIni = [
            'masuk' => Paket::whereMonth('tanggal_masuk', Carbon::now()->month)
                           ->whereYear('tanggal_masuk', Carbon::now()->year)
                           ->count(),
            'diambil' => Paket::whereMonth('tanggal_diambil', Carbon::now()->month)
                             ->whereYear('tanggal_diambil', Carbon::now()->year)
                             ->where('status', 'diambil')
                             ->count(),
            'denda' => Paket::whereMonth('tanggal_diambil', Carbon::now()->month)
                           ->whereYear('tanggal_diambil', Carbon::now()->year)
                           ->where('status', 'diambil')
                           ->sum('denda'),
        ];
        // ==========================================
        // AKTIVITAS ADMIN
        // ==========================================
        $aktivitasAdmin = LogAktivitas::select('user_id', DB::raw('count(*) as total'))
                                      ->with('user')
                                      ->groupBy('user_id')
                                      ->orderBy('total', 'desc')
                                      ->take(5)
                                      ->get();
        // ==========================================
        // PAKET TERLAMA BELUM DIAMBIL
        // ==========================================
        $paketTerlama = Paket::where('status', 'menunggu')
                             ->orderBy('tanggal_masuk', 'asc')
                             ->take(5)
                             ->get();
        return view('statistik.index', compact(
            'totalPaket',
            'paketDiambil',
            'paketMenunggu',
            'paketTelat',
            'persenDiambil',
            'persenMenunggu',
            'persenTelat',
            'totalDenda',
            'totalDendaTerkumpul',
            'totalDendaBelumBayar',
            'perEkspedisi',
            'perRak',
            'kapasitasRak',
            'dataBulanan',
            'labelBulanan',
            'dataMingguan',
            'labelMingguan',
            'topPenerima',
            'avgWaktuAmbil',
            'totalBerat',
            'avgBerat',
            'maxBerat',
            'minBerat',
            'hariIni',
            'bulanIni',
            'aktivitasAdmin',
            'paketTerlama'
        ));
    }
    /**
     * API untuk data realtime (AJAX)
     */
    public function getRealtimeData()
    {
        $data = [
            'total_paket' => Paket::count(),
            'paket_diambil' => Paket::where('status', 'diambil')->count(),
            'paket_menunggu' => Paket::where('status', 'menunggu')->count(),
            'paket_telat' => Paket::telat()->count(),
            'total_denda' => Paket::where('status', 'diambil')->sum('denda'),
            'paket_hari_ini' => Paket::whereDate('tanggal_masuk', Carbon::today())->count(),
        ];
        return response()->json($data);
    }
    /**
     * Export statistik ke PDF
     */
    public function exportPdf()
    {
        // Implementasi export PDF
    }
}