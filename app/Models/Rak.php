<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rak',
        'lokasi',
        'kapasitas',
        'terisi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * HITUNG SISA KAPASITAS OTOMATIS
     */
    public function getSisaKapasitasAttribute()
    {
        return max(0, $this->kapasitas - $this->terisi);
    }
}
