<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPelanggan extends Model
{
    protected $fillable = ['id_pelanggan', 'alamat', 'kota', 'provinsi', 'kode_pos', 'alamat_utama'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
