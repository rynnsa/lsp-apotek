<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obats'; // Nama tabel di database
    protected $fillable = [
        'nama_obat', 
        'id_jenis',
        'harga_jual',
        'deskripsi_obat',
        'foto1',
        'foto2',
        'foto3',
        'stok'
    ]; 

    public function jenis_obat()
    {
        return $this->belongsTo(JenisObat::class, 'id_jenis');
    }
}
