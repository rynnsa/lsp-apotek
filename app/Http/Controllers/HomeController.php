<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $obats = Obat::with('jenis_obat')->get();
        $jenis_obats = JenisObat::all();
        
        
        return view('home.index', [ 
            'title' => 'Apotek LifeCareYou',
            'obats' => $obats,
            'jenis_obats' => $jenis_obats
        ]);
    }
}