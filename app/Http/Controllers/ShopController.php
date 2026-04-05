<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        $obats = Obat::with('jenis_obat')->orderBy('id', 'DESC')->paginate(6);
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
        $query = Obat::with('jenis_obat');
        
        if ($request->search) {
            $query->where('nama_obat', 'LIKE', '%' . $request->search . '%');
        }
        
        if ($request->jenis) {
            $query->whereHas('jenis_obat', function($q) use ($request) {
                $q->where('jenis', $request->jenis);
            });
        }
        
        // Urutkan berdasarkan ID terbaru (DESC) untuk produk baru muncul di atas
        $obats = $query->orderBy('id', 'DESC')->paginate(6);
        
        $html = '';
        if ($obats->isEmpty()) {
            $html = '<div class="col-12"><p class="text-muted">Produk tidak ditemukan.</p></div>';
        } else {
            $isAuthenticated = auth('pelanggan')->check();
            foreach ($obats as $obat) {
                $html .= '<div class="col-md-6 col-lg-6 col-xl-4">';
                $html .= '<div class="rounded position-relative fruite-item">';
                $html .= '<div class="fruite-img" style="height: 250px; overflow: hidden; border-left: 1px solid #fbbd00; border-right: 1px solid #fbbd00; border-top: 1px solid #fbbd00;">';
                $html .= '<img src="' . asset('storage/' . $obat->foto1) . '" class="img-fluid w-100 rounded-top" alt="" style="object-fit: cover; height: 100%;">';
                $html .= '</div>';
                $html .= '<div class="text-white bg-secondary px-3 py-1 position-absolute text-center" style="top: 1px; right: 0; left: 0; display: flex; justify-content: center; align-items: center; border-radius: 10px 10px 0px 0px; border: 1px solid #fbbd00;">';
                $html .= $obat->jenis_obat->jenis;
                $html .= '</div>';
                $html .= '<div class="p-4 border border-secondary border-top-0 rounded-bottom" style="height: 180px;">';
                $html .= '<a href="' . route('shop-detail', ['id' => $obat->id]) . '" class="text-decoration-none">';
                $html .= '<h4 class="mb-1">' . $obat->nama_obat . '</h4>';
                $html .= '<p style="height: 50px; overflow: hidden;" class="text-dark">' . Str::limit($obat->deskripsi_obat, 100) . '</p>';
                $html .= '</a>';
                $html .= '<div class="d-flex justify-content-between flex-lg-wrap mt-auto">';
                $html .= '<p class="text-dark fs-5 fw-bold mb-0">Rp ' . number_format($obat->harga_jual, 0, ',', '.') . '</p>';
                if ($isAuthenticated) {
                    $html .= '<button onclick="tambahKeKeranjang(event, ' . $obat->id . ')" class="btn border border-secondary rounded-pill px-3 text-primary">';
                } else {
                    $html .= '<button onclick="window.location.href=\'' . route('login') . '\'" class="btn border border-secondary rounded-pill px-3 text-primary">';
                }
                $html .= '<i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah';
                $html .= '</button>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        
        // Generate pagination HTML
        $pagination = '';
        if ($obats->hasPages()) {
            for ($i = 1; $i <= $obats->lastPage(); $i++) {
                if ($i == $obats->currentPage()) {
                    $pagination .= '<a href="#" class="active rounded page-link" data-page="' . $i . '">' . $i . '</a>';
                } else {
                    $pagination .= '<a href="#" class="rounded page-link" data-page="' . $i . '">' . $i . '</a>';
                }
            }
            if ($obats->currentPage() > 1) {
                $pagination = '<a href="#" class="rounded page-link" data-page="1">&laquo;</a>' . $pagination;
            }
            if ($obats->hasMorePages()) {
                $pagination .= '<a href="#" class="rounded page-link" data-page="' . $obats->lastPage() . '">&raquo;</a>';
            }
        }
        
        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'currentPage' => $obats->currentPage(),
            'lastPage' => $obats->lastPage()
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

