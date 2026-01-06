<?php

namespace App\Services;

use App\Models\Paket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;

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
        $pesan = "📦 *Paket Anda Telah Tiba!*\n\n"
               . "Resi: {$paket->no_resi}\n"
               . "Ekspedisi: {$paket->ekspedisi}\n"
               . "Rak: {$paket->rak}\n"
               . "Batas ambil: {$paket->batas_pengambilan}\n\n"
               . "Silakan segera diambil. Terima kasih 🙏";

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
