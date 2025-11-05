<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';
    protected $fillable = [
        'no_nota',
        'tgl_pembelian',
        'total_bayar',
        'id_distributor'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    public function detail_pembelians()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }

    
}
