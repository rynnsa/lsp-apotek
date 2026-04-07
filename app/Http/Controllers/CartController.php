<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Keranjang;
use App\Models\JenisPengiriman;
use App\Models\MetodeBayar;
use App\Models\Penjualan;
use App\Models\AlamatPelanggan;
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

        // Get user addresses from profile or database
        $userAddresses = [
            [
                'nama_penerima' => $user->nama_pelanggan,
                'alamat' => $user->alamat1,
                'kota' => $user->kota1,
                'propinsi' => $user->propinsi1,
                'kodepos' => $user->kodepos1
            ],
            [
                'nama_penerima' => $user->nama_pelanggan,
                'alamat' => $user->alamat2,
                'kota' => $user->kota2,
                'propinsi' => $user->propinsi2,
                'kodepos' => $user->kodepos2
            ],
            [
                'nama_penerima' => $user->nama_pelanggan,
                'alamat' => $user->alamat3,
                'kota' => $user->kota3,
                'propinsi' => $user->propinsi3,
                'kodepos' => $user->kodepos3
            ]
        ];

        // Filter out empty addresses
        $userAddresses = array_filter($userAddresses, function($addr) {
            return !empty($addr['alamat']);
        });

        // Get provinces from Raja Ongkir API with caching and fallback
        $provinces = [];
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

            if ($response->successful()) {
                $provinces = $response->json()['data'] ?? [];
                // Cache successful response for 1 hour
                \Illuminate\Support\Facades\Cache::put('rajaongkir_provinces', $provinces, 3600);
            } else {
                \Illuminate\Support\Facades\Log::warning('Province API failed:', ['status' => $response->status(), 'body' => $response->body()]);
                // Use cached data or fallback
                $provinces = \Illuminate\Support\Facades\Cache::get('rajaongkir_provinces', $this->getFallbackProvinces());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to fetch provinces: ' . $e->getMessage());
            // Use cached data or fallback
            $provinces = \Illuminate\Support\Facades\Cache::get('rajaongkir_provinces', $this->getFallbackProvinces());
        }

        // Debug: Log the first province structure
        if (!empty($provinces)) {
            \Illuminate\Support\Facades\Log::info('Province structure:', ['first' => $provinces[0]]);
        }

        return view('fe.checkout', [
            'title' => 'Pemesanan - LifeCareYou',
            'keranjangItems' => $keranjangItems,
            'subtotal' => $subtotal,
            'jenisPengiriman' => JenisPengiriman::all(),
            'metodeBayar' => MetodeBayar::all(),
            'userAddresses' => $userAddresses,
            'provinces' => $provinces,
            'requiresPrescription' => false, // TODO: Calculate based on items
        ]);
    }

    /**
     * Get fallback provinces data when API is not available
     */
    private function getFallbackProvinces()
    {
        return [
            ['id' => 1, 'name' => 'ACEH'],
            ['id' => 2, 'name' => 'SUMATERA UTARA'],
            ['id' => 3, 'name' => 'SUMATERA BARAT'],
            ['id' => 4, 'name' => 'RIAU'],
            ['id' => 5, 'name' => 'JAMBI'],
            ['id' => 6, 'name' => 'SUMATERA SELATAN'],
            ['id' => 7, 'name' => 'BENGKULU'],
            ['id' => 8, 'name' => 'LAMPUNG'],
            ['id' => 9, 'name' => 'KEPULAUAN BANGKA BELITUNG'],
            ['id' => 10, 'name' => 'KEPULAUAN RIAU'],
            ['id' => 11, 'name' => 'DKI JAKARTA'],
            ['id' => 12, 'name' => 'JAWA BARAT'],
            ['id' => 13, 'name' => 'JAWA TENGAH'],
            ['id' => 14, 'name' => 'DI YOGYAKARTA'],
            ['id' => 15, 'name' => 'JAWA TIMUR'],
            ['id' => 16, 'name' => 'BANTEN'],
            ['id' => 17, 'name' => 'BALI'],
            ['id' => 18, 'name' => 'NUSA TENGGARA BARAT'],
            ['id' => 19, 'name' => 'NUSA TENGGARA TIMUR'],
            ['id' => 20, 'name' => 'KALIMANTAN BARAT'],
            ['id' => 21, 'name' => 'KALIMANTAN TENGAH'],
            ['id' => 22, 'name' => 'KALIMANTAN SELATAN'],
            ['id' => 23, 'name' => 'KALIMANTAN TIMUR'],
            ['id' => 24, 'name' => 'KALIMANTAN UTARA'],
            ['id' => 25, 'name' => 'SULAWESI UTARA'],
            ['id' => 26, 'name' => 'SULAWESI TENGAH'],
            ['id' => 27, 'name' => 'SULAWESI SELATAN'],
            ['id' => 28, 'name' => 'SULAWESI TENGGARA'],
            ['id' => 29, 'name' => 'GORONTALO'],
            ['id' => 30, 'name' => 'SULAWESI BARAT'],
            ['id' => 31, 'name' => 'MALUKU'],
            ['id' => 32, 'name' => 'MALUKU UTARA'],
            ['id' => 33, 'name' => 'PAPUA BARAT'],
            ['id' => 34, 'name' => 'PAPUA'],
        ];
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
            
            // Get shipping address from user profile
            $shippingAddressIndex = $request->shipping_address;
            $userAddresses = [
                ['alamat' => $user->alamat1, 'kota' => $user->kota1, 'propinsi' => $user->propinsi1, 'kodepos' => $user->kodepos1],
                ['alamat' => $user->alamat2, 'kota' => $user->kota2, 'propinsi' => $user->propinsi2, 'kodepos' => $user->kodepos2],
                ['alamat' => $user->alamat3, 'kota' => $user->kota3, 'propinsi' => $user->propinsi3, 'kodepos' => $user->kodepos3]
            ];

            $shippingAddress = $userAddresses[$shippingAddressIndex] ?? [];

            if (empty($shippingAddress['alamat'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat pengiriman tidak valid'
                ], 400);
            }

            DB::beginTransaction();
            try {
                $selectedItems = session('checkout_items', []);
                $cartItems = Keranjang::with('obat')
                    ->where('id_pelanggan', $user->id)
                    ->whereIn('id_obat', $selectedItems)
                    ->get();

                $subtotal = $cartItems->sum('subtotal');
                $ongkir = floatval($request->ongkir ?? 0);
                $biaya_app = $subtotal * 0.10; // Calculate 10% of subtotal
                $total_bayar = $subtotal + $ongkir + $biaya_app;

                // Create penjualan with shipping address and Raja Ongkir data
                $penjualan = Penjualan::create([
                    'id_pelanggan' => $user->id,
                    'id_metode_bayar' => $request->id_metode_bayar,
                    'id_jenis_kirim' => 1, // Default jenis kirim (bisa di-update nanti)
                    'tgl_penjualan' => now(),
                    'url_resep' => $request->hasFile('url_resep') ? 
                        $request->file('url_resep')->store('resep', 'public') : null,
                    'status_order' => 'Menunggu Konfirmasi',
                    'keterangan_status' => 'Pesanan sedang diproses',
                    'ongkos_kirim' => $ongkir,
                    'biaya_app' => $biaya_app,
                    'total_bayar' => $total_bayar,
                    'no_resi' => Penjualan::generateNoResi(),
                    'alamat_pengiriman' => $shippingAddress['alamat'],
                    'kota_pengiriman' => $shippingAddress['kota'],
                    'provinsi_pengiriman' => $shippingAddress['propinsi'],
                    'kodepos_pengiriman' => $shippingAddress['kodepos'],
                    'courier' => $request->courier,
                    'shipping_package' => $request->shipping_package,
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
                Log::error('Order process error: ' . $e->getMessage());
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