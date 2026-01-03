<?php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role',
        'no_telepon',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
    'password' => 'hashed',
    'last_login' => 'datetime',
    'is_active' => 'boolean',
    ];


    // Relasi ke Paket
    public function pakets()
    {
        return $this->hasMany(Paket::class, 'admin_id');
    }

    // Relasi ke Log Aktivitas
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}