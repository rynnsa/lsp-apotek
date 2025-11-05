<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\JenisObat;

class ShopController extends Controller
{
    public function index()
    {
        $obats = Obat::with('jenis_obat')->get();
        $jenis_obats = JenisObat::all();
        return view('shop.index', [
            'title' => 'Produk - LifeCareYou',
            'obats' => $obats,
            'jenis_obats' => $jenis_obats
        ]);
    }

    public function shopdetail($id)
    {
        $obat = Obat::with('jenis_obat')->findOrFail($id);
        $related_products = Obat::with('jenis_obat')
            ->where('id_jenis', $obat->id_jenis)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('shop-detail.index', [
            'title' => $obat->nama_obat.' - LifeCareYou',
            'obat' => $obat,
            'related_products' => $related_products
        ]);
    }

    public function searchObat(Request $request)
    {
        $query = Obat::query();
        
        if ($request->search) {
            $query->where('nama_obat', 'LIKE', '%' . $request->search . '%');
        }
        
        if ($request->jenis) {
            $query->whereHas('jenis_obat', function($q) use ($request) {
                $q->where('jenis', $request->jenis);
            });
        }
        
        $obats = $query->get();
        
        return response()->json([
            'html' => view('fe.partials.obat-list', compact('obats'))->render()
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $obats = Obat::with('jenis_obat')
            ->where('nama_obat', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi_obat', 'LIKE', "%{$query}%")
            ->get();
        
        return response()->json($obats);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        
        $obats = Obat::where('nama_obat', 'LIKE', "%{$query}%")
            ->with('jenis_obat')
            ->get();
            
        return response()->json($obats);
    }

    public function filter(Request $request)
    {
        $jenis = $request->input('jenis');
        
        $query = Obat::with('jenis_obat');
        
        if ($jenis) {
            $query->whereHas('jenis_obat', function($q) use ($jenis) {
                $q->where('jenis', $jenis);
            });
        }
        
        $obats = $query->get();
        
        return response()->json($obats);
    }

    public function show($id)
    {
        // Get the specific medicine
        $obat = Obat::with('jenis_obat')->findOrFail($id);
        
        // Get related products with same medicine type
        $relatedProducts = Obat::where('id_jenis', $obat->id_jenis)
                              ->where('id', '!=', $obat->id)
                              ->where('stok', '>', 0)
                              ->take(8)
                              ->get();

        return view('shop-detail.index', [
            'title' => $obat->nama_obat . ' - LifeCareYou',
            'obats' => $obat,
            'related_products' => $relatedProducts
        ])->with('obat', $obat)->with('related_products', $relatedProducts);
    }

}

