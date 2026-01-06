<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Rak;
use App\Models\LogAktivitas;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaketController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    /**
     * Tampilkan daftar paket
     */
    public function index(Request $request)
    {
        $query = Paket::with('admin');

        // Filter pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_resi', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'telat') {
                $query->telat();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter rak
        if ($request->has('rak') && $request->rak) {
            $query->where('rak', $request->rak);
        }

        $pakets = $query->orderBy('created_at', 'desc')->paginate(10);
        $raks = Rak::where('is_active', true)->get();

        return view('paket.index', compact('pakets', 'raks'));
    }

    /**
     * Form input paket baru
     */
    public function create()
        {
            $raks = Rak::where('is_active', true)->get();
        
            $ekspedisiList = [
                'JNE',
                'J&T',
                'SiCepat',
                'AnterAja',
                'Shopee Express',
                'Tokopedia',
                'Lainnya'
            ];
        
            return view('paket.create', compact('raks', 'ekspedisiList'));
        }


    /**
     * Simpan paket baru + KIRIM NOTIFIKASI OTOMATIS
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|string|unique:pakets',
            'nama_penerima' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'ekspedisi' => 'required|string',
            'rak' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'tanggal_masuk' => 'required|date',
            'batas_pengambilan' => 'required|date|after_or_equal:tanggal_masuk',
        ], [
            'no_resi.required' => 'Nomor resi harus diisi',
            'no_resi.unique' => 'Nomor resi sudah terdaftar',
            'nama_penerima.required' => 'Nama penerima harus diisi',
            'no_whatsapp.required' => 'Nomor WhatsApp harus diisi',
            'ekspedisi.required' => 'Ekspedisi harus dipilih',
            'rak.required' => 'Rak harus dipilih',
            'berat.required' => 'Berat paket harus diisi',
            'berat.min' => 'Berat minimal 0.1 kg',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'batas_pengambilan.required' => 'Batas pengambilan harus diisi',
            'batas_pengambilan.after_or_equal' => 'Batas pengambilan harus setelah tanggal masuk',
        ]);

        // Simpan paket
        $paket = Paket::create([
            'no_resi' => $request->no_resi,
            'nama_penerima' => $request->nama_penerima,
            'no_whatsapp' => $request->no_whatsapp,
            'ekspedisi' => $request->ekspedisi,
            'rak' => $request->rak,
            'berat' => $request->berat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'batas_pengambilan' => $request->batas_pengambilan,
            'keterangan' => $request->keterangan,
            'admin_id' => Auth::id(),
            'status' => 'menunggu',
        ]);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'aksi' => 'input',
            'detail' => 'Menambahkan paket baru: ' . $paket->no_resi,
            'ip_address' => $request->ip(),
        ]);

        // Update kapasitas rak
        Rak::where('kode_rak', $request->rak)->increment('terisi');

        // =====================================================
        // 🚀 KIRIM NOTIFIKASI WHATSAPP OTOMATIS VIA FONNTE
        // =====================================================
        $pesanNotif = '';
        if ($request->has('kirim_notifikasi') && $request->kirim_notifikasi) {
            $hasil = $this->fonnte->notifikasiPaketMasuk($paket);
            
            if ($hasil['sukses']) {
                $pesanNotif = ' ✅ Notifikasi WhatsApp berhasil dikirim ke ' . $paket->nama_penerima . '!';
            } else {
                $pesanNotif = ' ❌ Gagal kirim notifikasi: ' . $hasil['pesan'];
            }
        }

        return redirect()->route('paket.index')
                         ->with('success', 'Paket berhasil ditambahkan!' . $pesanNotif);
    }

    /**
     * Tampilkan detail paket
     */
    public function show(Paket $paket)
    {
        return view('paket.show', compact('paket'));
    }

    /**
     * Form edit paket
     */
    public function edit(Paket $paket)
    {
        $raks = Rak::where('is_active', true)->get();
        $ekspedisiList = ['JNE', 'J&T', 'SiCepat', 'AnterAja', 'Shopee Express', 'Tokopedia', 'Lainnya'];
        
        return view('paket.edit', compact('paket', 'raks', 'ekspedisiList'));
    }

    /**
     * Update paket
     */
    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'no_resi' => 'required|string|unique:pakets,no_resi,' . $paket->id,
            'nama_penerima' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'ekspedisi' => 'required|string',
            'rak' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'status' => 'required|in:menunggu,diambil,dikembalikan',
        ]);

        $rakLama = $paket->rak;
        
        $paket->update($request->all());

        // Update rak jika berubah
        if ($rakLama !== $request->rak) {
            Rak::where('kode_rak', $rakLama)->decrement('terisi');
            Rak::where('kode_rak', $request->rak)->increment('terisi');
        }

        // Catat log
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'aksi' => 'edit',
            'detail' => 'Mengubah data paket resi: ' . $paket->no_resi,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('paket.index')
                         ->with('success', 'Data paket berhasil diperbarui!');
    }

    /**
     * Hapus paket
     */
    public function destroy(Request $request, Paket $paket)
    {
        // Kurangi jumlah di rak
        if ($paket->status === 'menunggu') {
            Rak::where('kode_rak', $paket->rak)->decrement('terisi');
        }

        // Catat log
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'paket_id' => null,
            'aksi' => 'hapus',
            'detail' => 'Menghapus paket resi: ' . $paket->no_resi,
            'ip_address' => $request->ip(),
        ]);

        $paket->delete();

        return redirect()->route('paket.index')
                         ->with('success', 'Paket berhasil dihapus!');
    }

    /**
     * Tandai paket sudah diambil + KIRIM NOTIFIKASI OTOMATIS
     */
    public function ambilPaket(Request $request, Paket $paket)
    {
        $hariTelat = 0;
        $denda = 0;

        if (Carbon::today()->gt($paket->batas_pengambilan)) {
            $hariTelat = Carbon::today()->diffInDays($paket->batas_pengambilan);
            $denda = $hariTelat * 1000; // Rp 1000/hari
        }

        $paket->update([
            'status' => 'diambil',
            'tanggal_diambil' => Carbon::today(),
            'hari_telat' => $hariTelat,
            'denda' => $denda,
        ]);

        // Kurangi jumlah di rak
        Rak::where('kode_rak', $paket->rak)->decrement('terisi');

        // Catat log
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'aksi' => 'ambil',
            'detail' => 'Paket diambil, denda: Rp ' . number_format($denda, 0, ',', '.'),
            'ip_address' => $request->ip(),
        ]);

        // =====================================================
        // 🚀 KIRIM NOTIFIKASI KONFIRMASI PENGAMBILAN VIA FONNTE
        // =====================================================
        $this->fonnte->notifikasiPaketDiambil($paket);

        return redirect()->back()
                         ->with('success', 'Paket berhasil ditandai sudah diambil! Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    /**
     * Tracking paket
     */
    public function tracking(Request $request)
    {
        $paket = null;
        
        if ($request->has('resi') && $request->resi) {
            $paket = Paket::where('no_resi', $request->resi)->first();
        }

        return view('paket.tracking', compact('paket'));
    }

    /**
     * Kirim notifikasi WhatsApp
     */
    public function kirimNotifikasi(Paket $paket)
    {
        $hasil = $this->fonnte->notifikasiPaketMasuk($paket);

        if ($hasil['sukses']) {
            return redirect()->back()
                             ->with('success', '✅ Notifikasi WhatsApp berhasil dikirim ke ' . $paket->nama_penerima . '!');
        }

        return redirect()->back()
                         ->with('error', '❌ Gagal mengirim notifikasi: ' . $hasil['pesan']);
    }

    /**
     * Kirim reminder WhatsApp
     */
    public function kirimReminder(Paket $paket)
    {
        $hasil = $this->fonnte->notifikasiReminder($paket);

        if ($hasil['sukses']) {
            return redirect()->back()
                             ->with('success', '✅ Reminder WhatsApp berhasil dikirim ke ' . $paket->nama_penerima . '!');
        }

        return redirect()->back()
                         ->with('error', '❌ Gagal mengirim reminder: ' . $hasil['pesan']);
    }

    /**
     * Kirim reminder ke semua paket telat
     */
    public function kirimSemuaReminder()
    {
        $paketTelat = Paket::where('status', 'menunggu')
                          ->where('batas_pengambilan', '<', Carbon::today())
                          ->get();

        $berhasil = 0;
        $gagal = 0;

        foreach ($paketTelat as $paket) {
            $hasil = $this->fonnte->notifikasiReminder($paket);
            
            if ($hasil['sukses']) {
                $berhasil++;
            } else {
                $gagal++;
            }

            // Delay 2 detik untuk menghindari rate limit
            sleep(2);
        }

        return redirect()->back()
                         ->with('success', "Reminder terkirim: {$berhasil} berhasil, {$gagal} gagal");
    }
}
