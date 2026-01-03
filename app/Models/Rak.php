<?php
// File: app/Models/Rak.php

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

    // Hitung sisa kapasitas
    public function getSisaKapasitasAttribute()
    {
        return $this->kapasitas - $this->terisi;
    }

    // Cek apakah rak penuh
    public function getIsPenuhAttribute()
    {
        return $this->terisi >= $this->kapasitas;
    }
}