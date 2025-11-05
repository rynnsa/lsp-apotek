<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        
        $params = array(
            'transaction_details' => array(
                'order_id' => $penjualan->no_resi,
                'gross_amount' => (int) $penjualan->total_bayar
            )
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            $notification = $request->all();
            
            $orderId = $notification['order_id'];
            $transactionStatus = $notification['transaction_status'];
            
            $penjualan = Penjualan::with('detail_penjualans.obat')
                ->where('no_resi', $orderId)
                ->first();

            if ($penjualan) {
                DB::beginTransaction();
                try {
                    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                        // Update status to Diproses
                        $penjualan->status_order = 'Diproses';
                        $penjualan->keterangan_status = 'Pembayaran berhasil, pesanan sedang diproses';
                        $penjualan->save();

                        // Decrease stock for each product
                        foreach ($penjualan->detail_penjualans as $detail) {
                            $obat = $detail->obat;
                            if ($obat->stok >= $detail->jumlah_beli) {
                                $obat->stok -= $detail->jumlah_beli;
                                $obat->save();
                            }
                        }
                    } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                        $penjualan->status_order = 'Batal';
                        $penjualan->keterangan_status = 'Pembayaran ' . $transactionStatus;
                        $penjualan->save();
                    }
                    
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($id)
    {
        try {
            $penjualan = Penjualan::find($id);
            $status = 'pending';
            
            if ($penjualan->status_order == 'Diproses') {
                $status = 'settlement';
            } else if ($penjualan->status_order == 'Batal') {
                $status = 'cancel';
            }
            
            return response()->json([
                'success' => true,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $penjualan = Penjualan::findOrFail($id);
            
            if ($request->transaction_status === 'settlement') {
                $penjualan->status_order = 'Diproses';
                $penjualan->keterangan_status = 'Pembayaran berhasil, pesanan sedang diproses';
                $penjualan->save();

                // Update stok obat
                foreach ($penjualan->detail_penjualans as $detail) {
                    $obat = $detail->obat;
                    $obat->stok -= $detail->jumlah_beli;
                    $obat->save();
                }
            }

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
}

