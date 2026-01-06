<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rak;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
        public function run(): void
    {
        $this->call([
            RakSeeder::class,
        ]);
    }


        // Buat data rak jika belum ada
        $raks = ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3'];
        foreach ($raks as $kode) {
            if (!Rak::where('kode_rak', $kode)->exists()) {
                Rak::create([
                    'kode_rak' => $kode,
                    'lokasi' => 'Gedung Utama',
                    'kapasitas' => 50,
                    'terisi' => 0,
                ]);
            }
        }

        // Pengaturan default jika belum ada
        $pengaturans = [
            ['key' => 'denda_per_hari', 'value' => '1000', 'deskripsi' => 'Nominal denda keterlambatan per hari (Rp)'],
            ['key' => 'batas_pengambilan_default', 'value' => '3', 'deskripsi' => 'Jumlah hari default untuk batas pengambilan'],
        ];

        foreach ($pengaturans as $pengaturan) {
            if (!Pengaturan::where('key', $pengaturan['key'])->exists()) {
                Pengaturan::create($pengaturan);
            }
        }
    }
}
