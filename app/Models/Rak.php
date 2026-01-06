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

    public function getSisaKapasitasAttribute()
    {
        return max(0, (int)$this->kapasitas - (int)$this->terisi);
    }

    public function getIsPenuhAttribute()
    {
        return (int)$this->terisi >= (int)$this->kapasitas;
    }
}
