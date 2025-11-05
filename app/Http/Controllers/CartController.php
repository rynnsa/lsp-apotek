<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Keranjang;
use App\Models\JenisPengiriman;
use App\Models\MetodeBayar;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\MidtransService;
use PhpParser\Node\NullableType;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang belanja
     */
    public function index()
    {
        $user = Auth::guard('pelanggan')->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $keranjangItems = Keranjang::with('obat')
            ->where('id_pelanggan', $user->id)
            ->get();

        return view('cart.index', [
            'title' => 'Keranjang - LifeCareYou',
            'keranjangs' => $keranjangItems
        ]);
    }

    /**
     * Mendapatkan jumlah item di keranjang (untuk AJAX)
     */
    public function getCartCount()
    {
        $user = Auth::guard('pelanggan')->user();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = Keranjang::where('id_pelanggan', $user->id)->sum('jumlah_order');
        
        return response()->json(['count' => $count]);
    }

    /**
     * Menambahkan item ke keranjang
     */
    public function add(Request $request)
    {
        try {
            $user = Auth::guard('pelanggan')->user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Silakan login terlebih dahulu'
                ], 401);
            }

            // Validasi input dengan nama tabel yang benar
            $validator = Validator::make($request->all(), [
                'obat_id' => 'required|exists:obats,id',  // Changed from obat to obats
                'jumlah' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Cek stok obat
            $obat = Obat::findOrFail($request->obat_id);
            if ($obat->stok < $request->jumlah) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            // Cek apakah obat sudah ada di keranjang
            $keranjang = Keranjang::where('id_pelanggan', $user->id)
                                ->where('id_obat', $request->obat_id)
                                ->first();

            DB::beginTransaction();
            try {
                if ($keranjang) {
                    // Update jumlah jika sudah ada
                    $keranjang->jumlah_order += $request->jumlah;
                    $keranjang->subtotal = $obat->harga_jual * $keranjang->jumlah_order;
                    $keranjang->save();
                } else {
                    // Buat item baru jika belum ada
                    Keranjang::create([
                        'id_pelanggan' => $user->id,
                        'id_obat' => $request->obat_id,
                        'jumlah_order' => $request->jumlah,
                        'harga' => $obat->harga_jual,
                        'subtotal' => $obat->harga_jual * $request->jumlah
                    ]);
                }
                DB::commit();

                // Hitung total item di keranjang
                $cartCount = Keranjang::where('id_pelanggan', $user->id)
                                    ->sum('jumlah_order');

                return response()->json([
                    'status' => 'success',
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'cart_count' => $cartCount
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan ke keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengupdate jumlah item di keranjang
     */
    public function updateQuantity(Request $request)
    {
        try {
            $user = Auth::guard('pelanggan')->user();

            $request->validate([
                'obat_id' => 'required|exists:obats,id',  // Make sure this is also using obats
                'jumlah' => 'required|integer|min:1'
            ]);

            // Cek stok tersedia
            $obat = Obat::findOrFail($request->obat_id);
            if ($obat->stok < $request->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            $item = Keranjang::where('id_pelanggan', $user->id)
                            ->where('id_obat', $request->obat_id)
                            ->firstOrFail();

            $item->update(['jumlah_order' => $request->jumlah]);

            return response()->json([
                'success' => true,
                'total_harga' => number_format($item->obat->harga_jual * $request->jumlah, 0, ',', '.')
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating cart quantity: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate jumlah produk'
            ], 500);
        }
    }

    /**
     * Menghapus item dari keranjang
     */
    public function removeItem(Request $request)
    {
        try {
            $user = Auth::guard('pelanggan')->user();

            $request->validate([
                'obat_id' => 'required|exists:obats,id'  // Make sure this is also using obats
            ]);

            Keranjang::where('id_pelanggan', $user->id)
                    ->where('id_obat', $request->obat_id)
                    ->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error removing cart item: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk dari keranjang'
            ], 500);
        }
    }

    /**
     * Menampilkan halaman checkout
     */
    public function checkout()
    {
        $user = Auth::guard('pelanggan')->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Get selected items from session
        $selectedItems = session('checkout_items', []);
        
        if (empty($selectedItems)) {
            return redirect()->route('cart')
                ->with('error', 'Pilih produk untuk checkout');
        }

        // Get selected cart items
        $keranjangItems = Keranjang::with('obat')
            ->where('id_pelanggan', $user->id)
            ->whereIn('id_obat', $selectedItems)
            ->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Item yang dipilih tidak ditemukan');
        }

        $subtotal = $keranjangItems->sum('subtotal');

        return view('checkout.index', [
            'title' => 'Pemesanan - LifeCareYou',
            'keranjangItems' => $keranjangItems,
            'subtotal' => $subtotal,
            'jenisPengiriman' => JenisPengiriman::all(),
            'metodeBayar' => MetodeBayar::all(),
        ]);
    }

    public function processCheckout(Request $request)
    {
        try {
            $selectedItems = $request->input('selected_items', []);
            
            if (empty($selectedItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pilih minimal satu item'
                ], 400);
            }

            // Store selected items in session
            session(['checkout_items' => $selectedItems]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Checkout process error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses checkout'
            ], 500);
        }
    }


    public function createOrder(Request $request)
    {
        try {
            $user = Auth::guard('pelanggan')->user();
            
            $validator = Validator::make($request->all(), [
                'shipping_id' => 'required|exists:jenis_pengiriman,id',
                'payment_id' => 'required|exists:metode_bayar,id',
                'notes' => 'nullable|string',
                'url_resep' => 'nullable|file|image|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $selectedItems = session('checkout_items', []);
            $cartItems = Keranjang::with('obat')
                ->where('id_pelanggan', $user->id)
                ->whereIn('id_obat', $selectedItems)
                ->get();

            DB::beginTransaction();
            try {
                // Upload resep if exists
                $resepPath = null;
                if ($request->hasFile('url_resep')) {
                    $resepPath = $request->file('url_resep')->store('resep', 'public');
                }

                // Create penjualan record
                $penjualan = Penjualan::create([
                    'id_pelanggan' => $user->id,
                    'id_metode_bayar' => $request->payment_id,
                    'id_jenis_kirim' => $request->shipping_id,
                    'tgl_penjualan' => now(),
                    'url_resep' => $resepPath,
                    'catatan' => $request->notes,
                    'status_order' => 'Menunggu Pembayaran', // Ensure this matches the database
                    'keterangan_status' => 'Pesanan sedang diproses',
                    'total_bayar' => $cartItems->sum('subtotal'),
                    'ongkos_kirim' => $request->ongkos_kirim, // Adjust if additional fees are applicable
                    'biaya_app' => $request->biaya_app, // Adjust if additional fees are applicable
                    // 'keterangan_status' => 'Pesanan sedang diproses'
                ]);

                // Create detail penjualan records
                foreach ($cartItems as $item) {
                    $penjualan->detail_penjualans()->create([
                        'id_obat' => $item->id_obat,
                        'jumlah' => $item->jumlah_order,
                        'harga' => $item->harga,
                        'subtotal' => $item->subtotal
                    ]);

                    // Update stock
                    $item->obat->decrement('stok', $item->jumlah_order);
                }

                // Clear cart
                Keranjang::where('id_pelanggan', $user->id)
                        ->whereIn('id_obat', $selectedItems)
                        ->delete();

                // Clear checkout session
                session()->forget('checkout_items');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibuat'
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pesanan'
            ], 500);
    }
}

    public function processOrder(Request $request)
    {
        try {
            $user = Auth::guard('pelanggan')->user();
            
            // Get shipping type
            $jenisPengiriman = JenisPengiriman::findOrFail($request->id_jenis_kirim);
            
            // Calculate costs
            $ongkos_kirim = $jenisPengiriman->ongkos_kirim;

            DB::beginTransaction();
            try {
                $selectedItems = session('checkout_items', []);
                $cartItems = Keranjang::with('obat')
                    ->where('id_pelanggan', $user->id)
                    ->whereIn('id_obat', $selectedItems)
                    ->get();

                $subtotal = $cartItems->sum('subtotal');
                $biaya_app = $subtotal * 0.10; // Calculate 10% of subtotal
                $total_bayar = $subtotal + $ongkos_kirim + $biaya_app;

                // Create penjualan with costs
                $penjualan = Penjualan::create([
                    'id_pelanggan' => $user->id,
                    'id_metode_bayar' => $request->id_metode_bayar,
                    'id_jenis_kirim' => $request->id_jenis_kirim,
                    'tgl_penjualan' => now(),
                    'url_resep' => $request->hasFile('url_resep') ? 
                        $request->file('url_resep')->store('resep', 'public') : null,
                    'status_order' => 'Menunggu Konfirmasi',
                    'keterangan_status' => 'Pesanan sedang diproses',
                    'ongkos_kirim' => $ongkos_kirim,
                    'biaya_app' => $biaya_app,
                    'total_bayar' => $total_bayar,
                    'no_resi' => Penjualan::generateNoResi()
                ]);

                // Create detail_penjualan records
                foreach ($cartItems as $item) {
                    $penjualan->detail_penjualans()->create([
                        'id_obat' => $item->id_obat,
                        'jumlah_beli' => $item->jumlah_order,
                        'harga_beli' => $item->harga,
                        'subtotal' => $item->subtotal
                    ]);
                }

                // Clear cart and session
                Keranjang::where('id_pelanggan', $user->id)
                    ->whereIn('id_obat', $selectedItems)
                    ->delete();
                session()->forget('checkout_items');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibuat',
                    'redirect_url' => route('status-pemesanan')
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

}