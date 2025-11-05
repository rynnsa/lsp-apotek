<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    protected $table = 'keranjangs';

    protected $fillable = [
        'id_pelanggan',
        'id_obat',
        'jumlah_order',
        'harga',
        'subtotal'
    ];

    // Relasi ke Obat
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    // Relasi ke Pelanggan
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Accessor untuk subtotal (hitung dari harga * jumlah)
    // Pada model Keranjang
    public function getTotalHargaAttribute()
    {
        return $this->obat->harga_jual * $this->jumlah_order;
    }
}