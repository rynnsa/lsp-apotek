<!DOCTYPE html>
<html>
<head>
    <title>Statistik Pendapatan {{ $year }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .text-right { text-align: right; }
        .total { font-weight: bold; background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Statistik Pendapatan Tahun {{ $year }}</h2>
        <p>LifeCareYou Apotek</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyStats as $stat)
            <tr>
                <td>{{ $stat['month'] }}</td>
                <td class="text-right">
                    {{ $stat['sales_count'] }} transaksi<br>
                    <small>Rp {{ number_format($stat['sales_amount'], 0, ',', '.') }}</small>
                </td>
                <td class="text-right">
                    {{ $stat['purchase_count'] }} transaksi<br>
                    <small>Rp {{ number_format($stat['purchase_amount'], 0, ',', '.') }}</small>
                </td>
                <td class="text-right">Rp {{ number_format($stat['profit'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3" class="text-right">Total Profit:</td>
                <td class="text-right">Rp {{ number_format($total_profit, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
