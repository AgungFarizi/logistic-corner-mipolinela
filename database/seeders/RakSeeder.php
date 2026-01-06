<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rak;

class RakSeeder extends Seeder
{
    public function run(): void
    {
        $raks = [
            ['kode_rak'=>'A1','lokasi'=>'Blok A','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'A2','lokasi'=>'Blok A','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'A3','lokasi'=>'Blok A','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'B1','lokasi'=>'Blok B','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'B2','lokasi'=>'Blok B','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'B3','lokasi'=>'Blok B','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'C1','lokasi'=>'Blok C','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'C2','lokasi'=>'Blok C','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
            ['kode_rak'=>'C3','lokasi'=>'Blok C','kapasitas'=>10,'terisi'=>0,'is_active'=>1],
        ];

        foreach ($raks as $rak) {
            Rak::updateOrCreate(
                ['kode_rak' => $rak['kode_rak']],
                $rak
            );
        }
    }
}
