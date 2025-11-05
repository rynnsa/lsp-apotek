<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelians'; // Nama tabel di database
    protected $fillable = [
        'id_obat',
        'jumlah_beli',
        'harga_beli',
        'subtotal',
        'id_pembelian'	
    ]; 

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
