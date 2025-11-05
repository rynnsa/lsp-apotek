<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributors'; 
    protected $fillable = [
        'nama_distributor', 
        'telepon', 
        'alamat',
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_distributor');
    }
}

