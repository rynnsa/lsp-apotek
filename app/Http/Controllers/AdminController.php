<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PDF;

class AdminController extends Controller
{
    public function landing()
    {
        $currentYear = date('Y');
        
        $stats = [
            'total_transactions' => Penjualan::whereYear('created_at', $currentYear)->count(),
            'total_employees' => User::count(),
            'total_cancelled' => Penjualan::whereIn('status_order', ['Dibatalkan', 'Dibatalkan Pembeli', 'Dibatalkan Penjual'])
                                ->whereYear('created_at', $currentYear)
                                ->count(),
            'total_customers' => Pelanggan::count()
        ];

        return view('be.landing', [
            'title' => 'Dashmin LifeCareYou',
            'stats' => $stats
        ]);

    }

    public function index()
    {
        $year = request('year', date('Y'));
        
        $monthlyStats = $this->getMonthlyStats($year);
        
        $stats = [
            'total_sales' => Penjualan::where('status_order', 'Selesai')
                            ->whereYear('created_at', $year)
                            ->sum('total_bayar'),
            'total_purchases' => Pembelian::whereYear('tgl_pembelian', $year)
                                ->sum('total_bayar'),
            'total_customers' => Pelanggan::count(),
            'cancelled_orders' => Penjualan::where('status_order', 'Dibatalkan')
                                ->whereYear('created_at', $year)
                                ->count()
        ];

        return view('keuangan.index', [
            'title' => 'Dashmin LifeCareYou',
            'monthlyStats' => $monthlyStats,
            'stats' => $stats,
            'year' => $year
        ]);
    }

    private function getMonthlyStats($year)
    {
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $sales = Penjualan::where('status_order', 'Selesai')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $i);
                    
            $purchases = Pembelian::whereYear('tgl_pembelian', $year)
                        ->whereMonth('tgl_pembelian', $i);

            $months[] = [
                'year' => $year,
                'month' => Carbon::create()->month($i)->format('F'),
                'sales_count' => $sales->count(),
                'sales_amount' => $sales->sum('total_bayar'),
                'purchase_count' => $purchases->count(),
                'purchase_amount' => $purchases->sum('total_bayar'),
                'profit' => $sales->sum('total_bayar') - $purchases->sum('total_bayar'),
                'percentage' => $this->calculateGrowthPercentage($i, $year),
                'Percentage_growth' => $this->calculatePurchaseGrowthPercentage($i, $year)
            ];
        }

        return $months;
    }

    private function calculateGrowthPercentage($month, $year)
    {
        $currentMonth = Penjualan::where('status_order', 'Selesai')
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->sum('total_bayar');

        $lastMonth = Penjualan::where('status_order', 'Selesai')
                    ->whereYear('created_at', $month == 1 ? $year - 1 : $year)
                    ->whereMonth('created_at', $month == 1 ? 12 : $month - 1)
                    ->sum('total_bayar');

        if ($lastMonth == 0) return 0;
        return round(($currentMonth - $lastMonth) / $lastMonth * 100);
    }

    private function calculatePurchaseGrowthPercentage($month, $year)
    {
        $currentMonth = Pembelian::whereYear('tgl_pembelian', $year)
                        ->whereMonth('tgl_pembelian', $month)
                        ->sum('total_bayar');

        $lastMonth = Pembelian::whereYear('tgl_pembelian', $month == 1 ? $year - 1 : $year)
                    ->whereMonth('tgl_pembelian', $month == 1 ? 12 : $month - 1)
                    ->sum('total_bayar');

        if ($lastMonth == 0) return 0;
        return round(($currentMonth - $lastMonth) / $lastMonth * 100);
    }

    public function downloadSalesPDF()
    {
        $year = request('year', date('Y'));
        $monthlyStats = $this->getMonthlyStats($year);
        
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('pdf.sales-statistics', [
            'monthlyStats' => $monthlyStats,
            'year' => $year,
            'total' => array_sum(array_column($monthlyStats, 'sales_amount'))
        ]);
    
        return $pdf->download('statistik-penjualan-'.$year.'.pdf');
    }

    public function downloadPurchasesPDF()
    {
        $year = request('year', date('Y'));
        $monthlyStats = $this->getMonthlyStats($year);
        
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('pdf.purchases-statistics', [
            'monthlyStats' => $monthlyStats,
            'year' => $year,
            'total' => array_sum(array_column($monthlyStats, 'purchase_amount'))
        ]);
    
        return $pdf->download('statistik-pembelian-'.$year.'.pdf');
    }

    public function downloadIncomePDF()
    {
        $year = request('year', date('Y'));
        $monthlyStats = $this->getMonthlyStats($year);
        
        $total_profit = array_sum(array_column($monthlyStats, 'profit'));
        
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('pdf.income-statistics', [
            'monthlyStats' => $monthlyStats,
            'year' => $year,
            'total_profit' => $total_profit
        ]);
    
        return $pdf->download('statistik-pendapatan-'.$year.'.pdf');
    }

    public function apoteker()
    {
        return view('apoteker.index', ['title' => 'Dashmin LifeCareYou']);
    }
    public function karyawan()
    {
        return view('karyawan.index', ['title' => 'Dashmin LifeCareYou']);
    }
    public function kasir()
    {
        return view('kasir.index', ['title' => 'Dashmin LifeCareYou']);
    }
    public function pemilik()
    {
        return view('pemilik.index', ['title' => 'Dashmin LifeCareYou']);
    } 
}
