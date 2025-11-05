<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    protected $table = 'jenis_obats'; // Nama tabel di database
    protected $fillable = [
        'jenis', 
        'deskripsi_jenis', 
        'image_url',
    ]; 
}
