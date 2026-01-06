<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rak;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Rak::truncate();

        $data = [
            ['kode_rak' => 'A1', 'lokasi' => 'Rak A1', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'A2', 'lokasi' => 'Rak A2', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'A3', 'lokasi' => 'Rak A3', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'B1', 'lokasi' => 'Rak B1', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'B2', 'lokasi' => 'Rak B2', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'B3', 'lokasi' => 'Rak B3', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'C1', 'lokasi' => 'Rak C1', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'C2', 'lokasi' => 'Rak C2', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
            ['kode_rak' => 'C3', 'lokasi' => 'Rak C3', 'kapasitas' => 10, 'terisi' => 0, 'is_active' => true],
        ];

        foreach ($data as $rak) {
            Rak::create($rak);
        }
    }
}
