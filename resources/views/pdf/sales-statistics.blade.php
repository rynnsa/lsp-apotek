<!DOCTYPE html>
<html>
<head>
    <title>Statistik Penjualan {{ $year }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .total { font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Statistik Penjualan Tahun {{ $year }}</h2>
        <p>LifeCareYou Apotek</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Transaksi</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyStats as $stat)
            <tr>
                <td>{{ $stat['month'] }}</td>
                <td>{{ $stat['sales_count'] }}</td>
                <td>Rp {{ number_format($stat['sales_amount'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right"><strong>Total:</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
