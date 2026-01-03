<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans'; // atau nama tabelmu
    protected $fillable = [
        'key',
        'value',
        'deskripsi',
    ];
}
