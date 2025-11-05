<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggans';
    protected $guarded = ['id'];

    protected $hidden = [
        'katakunci',
        'remember_token',
    ];

    protected $fillable = [
        'nama_pelanggan',
        'email',
        'katakunci',
        'no_telp',
        'alamat1',
        'kota1',
        'propinsi1',
        'kodepos1',
        'alamat2',
        'kota2',
        'propinsi2',
        'kodepos2',
        'alamat3',
        'kota3',
        'propinsi3',
        'kodepos3',
        'foto',
        'url_ktp'
    ];

    public function getAuthPassword()
    {
        return $this->katakunci;
    }

    // Pada model Pelanggan
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pelanggan');
    }


}


