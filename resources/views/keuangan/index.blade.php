@extends('be.master-admin')  
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content') 
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <!-- Monthly Income Statistics Start -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Pendapatan</h5>
                                            <a href="{{ route('income.download-pdf') }}?year={{ $year }}" 
                                               class="btn btn-link p-0 text-primary" data-bs-toggle="tooltip" title="Unduh PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <select id="filtertahun" class="form-select form-control rounded-3 custom-select" style="width: 150px;" name="tahun" required>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Bulan</th>
                                                    <th>Penjualan</th>
                                                    <th>Pembelian</th>
                                                    <th>Profit</th>
                                                    <th>Perbandingan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($monthlyStats as $stat)
                                                <tr class="bg-white">
                                                    <td>{{ $stat['month'] }}</td>
                                                    <td>
                                                        {{ $stat['sales_count'] }} transaksi<br>
                                                        <small>Rp {{ number_format($stat['sales_amount'], 0, ',', '.') }}</small>
                                                    </td>
                                                    <td>
                                                        {{ $stat['purchase_count'] }} transaksi<br>
                                                        <small>Rp {{ number_format($stat['purchase_amount'], 0, ',', '.') }}</small>
                                                    </td>
                                                    <td>Rp {{ number_format($stat['profit'], 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="progress bg-light" data-bs-toggle="tooltip" title="{{ $stat['percentage'] }}%">
                                                            <div class="progress-bar {{ $stat['percentage'] > 0 ? 'bg-c-green' : 'bg-c-pink' }}" 
                                                                 style="width:{{ abs($stat['percentage']) }}%"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Monthly Income Statistics End -->

                        <!-- Sales Statistics Start -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                     <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Statistik Penjualan</h5>
                                            <a href="{{ route('sales.download-pdf') }}?year={{ $year }}" 
                                               class="btn btn-link p-0 text-primary" data-bs-toggle="tooltip" title="Unduh PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <select id="filterSalesTahun" class="form-select form-control rounded-3 custom-select" style="width: 150px;" name="tahun" required>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Bulan</th>
                                                    <th>Jumlah Transaksi</th>
                                                    <th>Total Penjualan</th>
                                                    <th>Trend</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($monthlyStats as $stat)
                                                <tr>
                                                    <td>{{ $stat['month'] }}</td>
                                                    <td>{{ $stat['sales_count'] }}</td>
                                                    <td>Rp {{ number_format($stat['sales_amount'], 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="progress bg-light" data-bs-toggle="tooltip" title="{{ $stat['percentage'] }}%">
                                                            <div class="progress-bar bg-c-blue" style="width:{{ abs($stat['percentage']) }}%"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Statistics Start -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Statistik Pembelian</h5>
                                            <a href="{{ route('purchases.download-pdf') }}?year={{ $year }}" 
                                               class="btn btn-link p-0 text-primary" data-bs-toggle="tooltip" title="Unduh PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <select id="filterPurchaseTahun" class="form-select form-control rounded-3 custom-select" style="width: 150px;" name="tahun" required>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Bulan</th>
                                                    <th>Jumlah Transaksi</th>
                                                    <th>Total Pembelian</th>
                                                    <th>Trend</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($monthlyStats as $stat)
                                                <tr>
                                                    <td>{{ $stat['month'] }}</td>
                                                    <td>{{ $stat['purchase_count'] }}</td>
                                                    <td>Rp {{ number_format($stat['purchase_amount'], 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="progress bg-light" data-bs-toggle="tooltip" title="{{ $stat['percentage'] }}%">
                                                            <div class="progress-bar bg-c-green" style="width:{{ abs($stat['percentage']) }}%"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="styleSelector">

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 9]>
<div class="ie-warning">
<h1>Warning!!</h1>
<p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
<div class="iew-container">
<ul class="iew-download">
<li>
<a href="http://www.google.com/chrome/">
<img src="{{asset ('be/img/browser/chrome.png') }}" alt="Chrome">
<div>Chrome</div>
</a>
</li>
<li>
<a href="https://www.mozilla.org/en-US/firefox/new/">
<img src="{{asset ('be/img/browser/firefox.png') }}" alt="Firefox">
<div>Firefox</div>
</a>
</li>
<li>
<a href="http://www.opera.com">
<img src="{{asset ('be/img/browser/opera.png') }}" alt="Opera">
<div>Opera</div>
</a>
</li>
<li>
<a href="https://www.apple.com/safari/">
<img src="{{asset ('be/img/browser/safari.png') }}" alt="Safari">
<div>Safari</div>
</a>
</li>
<li>
<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
<img src="{{asset ('be/img/browser/ie.png') }}" alt="">
<div>IE (9 & above)</div>
</a>
</li>
</ul>
</div>
<p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->

<script>
document.getElementById('yearFilter').addEventListener('change', function() {
const selectedYear = this.value;
// Here you can add AJAX call to fetch data for the selected year
// and update the table content
});
</script>

<!-- Initialize tooltips -->
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>

@push('styles')
<link rel="stylesheet" href="{{ asset('be/css/chart.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('be/js/chart.js') }}"></script>
<script>
document.getElementById('yearFilter').addEventListener('change', function() {
const selectedYear = this.value;
// Here you can add AJAX call to fetch data for the selected year
// and update the table content
});
</script>

<!-- Initialize tooltips -->
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush
@endsection