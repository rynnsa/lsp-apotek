<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public static function createTransaction($order)
    {
        self::configureMidtrans();

        $transaction_details = [
            'order_id' => $order->nomor_pesanan,
            'gross_amount' => $order->total_bayar
        ];

        $items = [];
        foreach ($order->detail_penjualans as $detail) {
            $items[] = [
                'id' => $detail->id_obat,
                'price' => $detail->harga_beli,
                'quantity' => $detail->jumlah_beli,
                'name' => $detail->obat->nama_obat
            ];
        }

        $customer_details = [
            'first_name' => $order->pelanggan->nama,
            'email' => $order->pelanggan->email,
            'phone' => $order->pelanggan->no_telp
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => $customer_details
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Error creating Midtrans transaction: ' . $e->getMessage());
        }
    }

    private static function configureMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
}
