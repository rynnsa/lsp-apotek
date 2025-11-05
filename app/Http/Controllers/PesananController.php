<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function status()
    {
        $user = Auth::guard('pelanggan')->user();

        $penjualan = Penjualan::with(['detail_penjualans.obat'])
            ->where('id_pelanggan', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('status-pemesanan.index', [
            'title' => 'Status Pemesanan - LifeCareYou',
            'penjualans' => $penjualan
        ]);
    }
    
    
}
