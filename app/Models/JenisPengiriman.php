<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengiriman extends Model
{
    protected $table = 'jenis_pengirimans';
    
    protected $fillable = [
        'nama_expedisi',
        'jenis_kirim',
        'ongkos_kirim',
        'logo_expedisi'
    ];
}
