<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan', 'metode_bayar', 'jenis_pengiriman', 'detail_penjualans.obat'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penjualan.index', [
            'title' => 'Dashmin LifeCareYou',
            'penjualans' => $penjualans
        ]);
    }

    public function show($id)
    {
        $penjualan = Penjualan::with([
            'pelanggan',
            'metode_bayar',
            'jenis_pengiriman',
            'detail_penjualans.obat'
        ])->findOrFail($id);

        $total = 0;
        foreach ($penjualan->detail_penjualans as $detail) {
            $total += $detail->jumlah_beli * $detail->obat->harga_jual;
        }
        $penjualan->total = $total;

        return response()->json($penjualan);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $penjualan = Penjualan::with('detail_penjualans.obat')->findOrFail($id);
            $oldStatus = $penjualan->status_order;
            $newStatus = $request->status;

            // If changing to Diproses, decrease stock
            if ($newStatus == 'Diproses' && $oldStatus != 'Diproses') {
                foreach ($penjualan->detail_penjualans as $detail) {
                    $obat = $detail->obat;
                    if ($obat->stok < $detail->jumlah_beli) {
                        throw new \Exception('Stok tidak mencukupi untuk ' . $obat->nama_obat);
                    }
                    $obat->stok -= $detail->jumlah_beli;
                    $obat->save();
                }
            }
            // If canceling from Diproses, restore stock
            else if ($oldStatus == 'Diproses' && ($newStatus == 'Batal' || $newStatus == 'Dibatalkan Penjual')) {
                foreach ($penjualan->detail_penjualans as $detail) {
                    $obat = $detail->obat;
                    $obat->stok += $detail->jumlah_beli;
                    $obat->save();
                }
            }

            $penjualan->status_order = $newStatus;
            $penjualan->save();

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSalesReport(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth();

        $sales = Penjualan::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Selesai')
            ->with(['pelanggan', 'detail_penjualan.obat'])
            ->get();

        $summary = [
            'total_sales' => $sales->sum('total_harga'),
            'total_orders' => $sales->count(),
            'average_order' => $sales->avg('total_harga'),
            'total_items' => $sales->sum('total_item')
        ];

        return response()->json([
            'sales' => $sales,
            'summary' => $summary
        ]);
    }

    public function status()
    {
        $user = Auth::guard('pelanggan')->user();

        $penjualan = Penjualan::with([
                'detail_penjualans.obat',
                'metode_bayar',
                'jenis_pengiriman'
            ])
            ->where('id_pelanggan', $user->id)
            ->latest('created_at') // This will order by created_at DESC
            ->get();
            
        return view('status-pemesanan.index', [
            'title' => 'Status Pemesanan - LifeCareYou',
            'penjualans' => $penjualan
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $penjualan->nomor_pesanan,
                'gross_amount' => $penjualan->total_bayar
            ),
            'item_details' => [
                [
                    'id' => $penjualan->detail_penjualans[0]->obat->id,
                    'price' => $penjualan->detail_penjualans[0]->harga_beli,
                    'quantity' => $penjualan->detail_penjualans[0]->jumlah_beli,
                    'name' => $penjualan->detail_penjualans[0]->obat->nama_obat
                ]
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_telp
            ]
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken
        ]);
        $penjualan->snap_token = $snapToken;
        $penjualan->save();
        $penjualan->update([
            'snap_token' => $snapToken
        ]);
        $penjualan->save(); 
    }

    public function penjualan(Penjualan $penjualan)
    {
        $obats = config('obat');
        $obat = collect($obats)->firstWhere('id', $penjualan->id_obat);
        return view('status-pemesanan.index', [
            'title' => 'Status Pemesanan - LifeCareYou',
            'penjualan' => $penjualan,
            'obat' => $obat
        ]);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('penjualan')
            ->with('success', 'Penjualan berhasil dihapus');
    }

    public function cancelOrder(Request $request, $id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);
            
            if (!in_array($penjualan->status_order, ['Menunggu Konfirmasi'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan'
                ], 400);
            }

            $penjualan->status_order = 'Dibatalkan Pembeli';
            $penjualan->keterangan_status = $request->keterangan ?? 'Dibatalkan oleh pembeli';
            $penjualan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
