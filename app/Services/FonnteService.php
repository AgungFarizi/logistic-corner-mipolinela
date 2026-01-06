<?php

namespace App\Services;

use App\Models\Paket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected ?string $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    protected function kirimPesan(string $nomor, string $pesan): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $nomor,
                'message' => $pesan,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                return ['sukses' => true];
            }

            return [
                'sukses' => false,
                'pesan' => $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());
            return [
                'sukses' => false,
                'pesan' => $e->getMessage()
            ];
        }
    }

    public function notifikasiPaketMasuk(Paket $paket): array
    {
       $pesan = "Hallo kak 👋\n\n"
       . "Paket dengan nama *{$paket->nama_penerima}*, "
       . "No Resi *{$paket->no_resi}* sudah sampai di "
       . "*Logistic Corner Polinela*.\n\n"
       . "Batas Ambil: *" . \Carbon\Carbon::parse($paket->batas_pengambilan)->translatedFormat('d M Y') . "*\n\n"
       . "Silahkan diambil dan konfirmasi oleh Admin yang ada disana yaa kak.\n\n"
       . "*Jika terlambat mengambil / Paket menginap akan dikenakan denda Rp. 1.000 per harinya.*\n\n"
       . "Terima kasihh 🙏\n\n"
       . "_Logistic Corner Polinela_\n\n"
       ;


        return $this->kirimPesan($paket->no_whatsapp, $pesan);
    }

    public function notifikasiReminder(Paket $paket): array
    {
        $pesan = "⏰ *Reminder Pengambilan Paket*\n\n"
               . "Resi: {$paket->no_resi}\n"
               . "Batas ambil: {$paket->batas_pengambilan}\n\n"
               . "Mohon segera diambil untuk menghindari denda.";

        return $this->kirimPesan($paket->no_whatsapp, $pesan);
    }

    public function notifikasiPaketDiambil(Paket $paket): array
    {
        $pesan = "✅ *Paket Telah Diambil*\n\n"
               . "Resi: {$paket->no_resi}\n"
               . "Terima kasih sudah mengambil paket Anda.";

        return $this->kirimPesan($paket->no_whatsapp, $pesan);
    }
}
