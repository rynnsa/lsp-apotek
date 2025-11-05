<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    
    protected $fillable = [
        'id_metode_bayar',
        'tgl_penjualan',
        'url_resep',
        'ongkos_kirim',
        'biaya_app',
        'total_bayar',
        'status_order',
        'keterangan_status',
        'id_jenis_kirim',
        'id_pelanggan',
        'no_resi',
    ];

    public static function generateNoResi()
    {
        $today = now()->format('Ymd');
        $lastResi = self::whereDate('created_at', now())
            ->max('no_resi');
            
        if ($lastResi) {
            $increment = intval(substr($lastResi, -4)) + 1;
        } else {
            $increment = 1;
        }

        return 'R12' . $today . str_pad($increment, 4, '0', STR_PAD_LEFT);
    }

    protected $casts = [
        'tgl_penjualan' => 'date',
    ];

    public function detail_penjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
    public function obat()
    {
        return $this->hasManyThrough(Obat::class, DetailPenjualan::class, 'id_penjualan', 'id', 'id', 'id_obat');
    }
    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function metode_bayar()
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }

    public function jenis_pengiriman()
    {
        return $this->belongsTo(JenisPengiriman::class, 'id_jenis_kirim');
    }

}
