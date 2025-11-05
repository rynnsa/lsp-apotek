<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $fillable = [
        'id_penjualan', 
        'no_invoice',   
        'nama_kurir',   
        'telpon_kurir',      
        'tgl_kirim',     
        'tgl_tiba',      
        'status_kirim',  
        'bukti_foto',    
        'keterangan',    
    ];

    protected $rules = [
        'id_penjualan' => 'required|exists:penjualans,id',
        'no_invoice' => 'required|string',
        'nama_kurir' => 'required|string',
        'telpon_kurir' => 'required|string',
    ];

    protected $casts = [
        'tgl_kirim' => 'datetime',
        'tgl_tiba' => 'datetime',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }
}
