<?php
// File: app/Models/Paket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_resi',
        'nama_penerima',
        'no_whatsapp',
        'ekspedisi',
        'rak',
        'berat',
        'tanggal_masuk',
        'batas_pengambilan',
        'tanggal_diambil',
        'status',
        'hari_telat',
        'denda',
        'keterangan',
        'admin_id',
        'notifikasi_terkirim',
        'waktu_notifikasi',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'batas_pengambilan' => 'date',
        'tanggal_diambil' => 'date',
        'waktu_notifikasi' => 'datetime',
        'berat' => 'decimal:2',
        'denda' => 'decimal:2',
        'notifikasi_terkirim' => 'boolean',
    ];

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Hitung hari telat otomatis
    public function getHariTelatAttribute()
    {
        if ($this->status === 'diambil') {
            return $this->attributes['hari_telat'];
        }

        $today = Carbon::today();
        $batas = Carbon::parse($this->batas_pengambilan);
        
        if ($today->gt($batas)) {
            return $today->diffInDays($batas);
        }
        
        return 0;
    }

    // Hitung denda otomatis (Rp 1000/hari)
    public function getDendaOtomatisAttribute()
    {
        return $this->hari_telat * 1000;
    }

    // Scope untuk paket yang belum diambil
    public function scopeBelumDiambil($query)
    {
        return $query->where('status', 'menunggu');
    }

    // Scope untuk paket yang telat
    public function scopeTelat($query)
    {
        return $query->where('status', 'menunggu')
                     ->where('batas_pengambilan', '<', Carbon::today());
    }

    // Scope berdasarkan tanggal
    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal_masuk', $tanggal);
    }

    // Scope berdasarkan bulan
    public function scopeBulan($query, $bulan, $tahun)
    {
        return $query->whereMonth('tanggal_masuk', $bulan)
                     ->whereYear('tanggal_masuk', $tahun);
    }

    // Scope berdasarkan tahun
    public function scopeTahun($query, $tahun)
    {
        return $query->whereYear('tanggal_masuk', $tahun);
    }
}