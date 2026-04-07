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

                    <!-- Modern Hero Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                                <div class="card-body p-5">
                                    <div class="row align-items-center">
                                        <div class="col-lg-8">
                                            <h1 class="display-4 font-weight-bold mb-3">
                                                <i></i>
                                                @if(Auth::user()->jabatan == 'pemilik')
                                                    Selamat Datang, Pemilik LifeCareYou
                                                @elseif(Auth::user()->jabatan == 'kasir')
                                                    Selamat Datang, Kasir LifeCareYou
                                                @elseif(Auth::user()->jabatan == 'apoteker')
                                                    Selamat Datang, Apoteker LifeCareYou
                                                @elseif(Auth::user()->jabatan == 'karyawan')
                                                    Selamat Datang, Karyawan LifeCareYou
                                                @elseif(Auth::user()->jabatan == 'kurir')
                                                    Selamat Datang, Kurir LifeCareYou
                                                @elseif(Auth::user()->jabatan == 'admin')
                                                    Selamat Datang, Admin LifeCareYou
                                                @else
                                                    Selamat Datang di LifeCareYou
                                                @endif
                                            </h1>
                                            <p class="lead">
                                                @if(Auth::user()->jabatan == 'pemilik')
                                                    Kelola bisnis apotek Anda dengan mudah. Pantau performa, kelola pengguna, dan optimalkan operasional harian.
                                                @elseif(Auth::user()->jabatan == 'kasir')
                                                    Kelola transaksi penjualan dan pembayaran dengan efisien. Pantau laporan keuangan dan performa penjualan.
                                                @elseif(Auth::user()->jabatan == 'apoteker')
                                                    Kelola inventori obat dan distributor. Pastikan ketersediaan obat dan kelola pembelian.
                                                @elseif(Auth::user()->jabatan == 'karyawan')
                                                    Kelola penjualan dan pengiriman. Bantu pelanggan dengan layanan terbaik.
                                                @elseif(Auth::user()->jabatan == 'kurir')
                                                    Kelola pengiriman dan distribusi obat. Pastikan pengiriman tepat waktu.
                                                @elseif(Auth::user()->jabatan == 'admin')
                                                    Kelola sistem dan pengguna. Pastikan operasional berjalan lancar.
                                                @else
                                                    Kelola bisnis apotek Anda dengan mudah dan efisien. Pantau penjualan, kelola inventori, dan optimalkan operasional harian.
                                                @endif
                                            </p>
                                            {{-- <div class="d-flex flex-wrap gap-3">
                                                @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'karyawan')
                                                <a href="{{ route('penjualan') }}" class="btn btn-light btn-lg px-4 py-2 shadow-sm">
                                                    <i class="fas fa-cash-register mr-2"></i>Penjualan
                                                </a>
                                                @elseif(Auth::user()->jabatan == 'apoteker' || Auth::user()->jabatan == 'admin')
                                                <a href="{{ route('obat') }}" class="btn btn-light btn-lg px-4 py-2 shadow-sm">
                                                    <i class="fas fa-pills mr-2"></i>Kelola Obat
                                                </a>
                                                @elseif(Auth::user()->jabatan == 'pemilik')
                                                <a href="{{ route('keuangan') }}" class="btn btn-light btn-lg px-4 py-2 shadow-sm">
                                                    <i class="fas fa-chart-bar mr-2"></i>Laporan Keuangan
                                                </a>
                                                @elseif(Auth::user()->jabatan == 'kurir')
                                                <a href="{{ route('data-pengiriman') }}" class="btn btn-light btn-lg px-4 py-2 shadow-sm">
                                                    <i class="fas fa-truck mr-2"></i>Data Pengiriman
                                                </a>
                                                @endif

                                                @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'pemilik')
                                                <a href="{{ route('keuangan') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                                                    <i class="fas fa-chart-line mr-2"></i>Lihat Laporan
                                                </a>
                                                @elseif(Auth::user()->jabatan == 'apoteker')
                                                <a href="{{ route('pembelian.create') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                                                    <i class="fas fa-shopping-cart mr-2"></i>Pembelian Baru
                                                </a>
                                                @elseif(Auth::user()->jabatan == 'karyawan')
                                                <a href="{{ route('jenis-pengiriman') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                                                    <i class="fas fa-shipping-fast mr-2"></i>Kelola Pengiriman
                                                </a>
                                                @endif
                                            </div> --}}
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <div class="hero-icon">
                                                <i class="fas fa-pills fa-6x text-white opacity-75"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <!-- Total Transactions Card -->
                        <div class="col-md col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                                    <span class="text-c-blue f-w-600">Total Penjualan</span>
                                    <h5>{{ $stats['total_transactions'] }}</h5>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-blue f-16 icofont icofont-check m-r-10"></i>Tahun {{ date('Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Employees Card -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-ui-home bg-c-pink card1-icon"></i>
                                    <span class="text-c-pink f-w-600">Karyawan</span>
                                    <h5>{{ $stats['total_employees'] }}</h5>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-pink f-16 icofont icofont-calendar m-r-10"></i>Total karyawan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancelled Orders Card -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-warning-alt bg-c-green card1-icon"></i>
                                    <span class="text-c-green f-w-600">Dibatalkan</span>
                                    <h5>{{ $stats['total_cancelled'] }}</h5>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-green f-16 icofont icofont-tag m-r-10"></i>Produk dibatalkan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Customers Card -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-social-twitter bg-c-yellow card1-icon"></i>
                                    <span class="text-c-yellow f-w-600">Pelanggan</span>
                                    <h5>{{ $stats['total_customers'] }}</h5>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-yellow f-16 icofont icofont-refresh m-r-10"></i>Total pelanggan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-4">
                                    <h4 class="mb-0 text-dark">
                                        <i class="text-warning mr-2"></i>Aksi Cepat
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'karyawan')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('penjualan') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-cash-register fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Penjualan</h6>
                                                    <small class="text-muted">Kelola transaksi</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'pemilik')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('keuangan') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-chart-bar fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Laporan Keuangan</h6>
                                                    <small class="text-muted">Pantau performa</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'apoteker' || Auth::user()->jabatan == 'admin')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('obat') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-pills fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Kelola Obat</h6>
                                                    <small class="text-muted">Inventori obat</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'apoteker')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('pembelian.create') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-shopping-bag fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Pembelian Baru</h6>
                                                    <small class="text-muted">Beli dari distributor</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'pemilik' || Auth::user()->jabatan == 'admin')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('kelola-pengguna') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-secondary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-users-cog fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Kelola Pengguna</h6>
                                                    <small class="text-muted">Manajemen user</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'apoteker')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('distributor') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-dark text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-truck fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Distributor</h6>
                                                    <small class="text-muted">Kelola supplier</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'karyawan')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('jenis-pengiriman') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-shipping-fast fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Pengiriman</h6>
                                                    <small class="text-muted">Atur pengiriman</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'kurir')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('data-pengiriman') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-clipboard-list fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Data Pengiriman</h6>
                                                    <small class="text-muted">Lihat pengiriman</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif

                                        @if(Auth::user()->jabatan == 'kasir')
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('metodebayar') }}" class="text-decoration-none">
                                                <div class="action-card text-center p-4 border rounded-lg hover-shadow">
                                                    <div class="action-icon bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-credit-card fa-lg"></i>
                                                    </div>
                                                    <h6 class="text-dark mb-1">Metode Bayar</h6>
                                                    <small class="text-muted">Kelola pembayaran</small>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Analytics Section -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 text-dark">
                                        <i class="fas fa-chart-area text-primary mr-2"></i>Trend Penjualan Bulanan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="salesChart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 text-dark">
                                        <i class="fas fa-clock text-success mr-2"></i>Aktivitas Terbaru
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="activity-list">
                                        <div class="activity-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                            <div class="activity-icon bg-primary text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; min-width: 35px;">
                                                <i class="fas fa-plus fa-sm"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 text-dark small">Obat baru ditambahkan ke inventori</p>
                                                <small class="text-muted">2 jam yang lalu</small>
                                            </div>
                                        </div>
                                        <div class="activity-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                            <div class="activity-icon bg-success text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; min-width: 35px;">
                                                <i class="fas fa-shopping-cart fa-sm"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 text-dark small">Penjualan berhasil diproses</p>
                                                <small class="text-muted">4 jam yang lalu</small>
                                            </div>
                                        </div>
                                        <div class="activity-item d-flex align-items-start mb-3 pb-3 border-bottom">
                                            <div class="activity-icon bg-warning text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; min-width: 35px;">
                                                <i class="fas fa-truck fa-sm"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 text-dark small">Pengiriman dalam proses</p>
                                                <small class="text-muted">6 jam yang lalu</small>
                                            </div>
                                        </div>
                                        <div class="activity-item d-flex align-items-start">
                                            <div class="activity-icon bg-info text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; min-width: 35px;">
                                                <i class="fas fa-user-plus fa-sm"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 text-dark small">Pelanggan baru terdaftar</p>
                                                <small class="text-muted">1 hari yang lalu</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Status and Quick Info -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 text-dark">
                                        <i class="fas fa-shield-alt text-success mr-2"></i>Status Sistem
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-dark">
                                            <i class="fas fa-server text-success mr-2"></i>Server Status
                                        </span>
                                        <span class="badge badge-success px-3 py-1">Online</span>
                                    </div>
                                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-dark">
                                            <i class="fas fa-database text-primary mr-2"></i>Database
                                        </span>
                                        <span class="badge badge-success px-3 py-1">Connected</span>
                                    </div>
                                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-dark">
                                            <i class="fas fa-clock text-info mr-2"></i>Last Backup
                                        </span>
                                        <span class="badge badge-info px-3 py-1">Today</span>
                                    </div>
                                    <div class="status-item d-flex justify-content-between align-items-center">
                                        <span class="text-dark">
                                            <i class="fas fa-users text-warning mr-2"></i>Active Users
                                        </span>
                                        <span class="badge badge-warning px-3 py-1">{{ $stats['total_employees'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 text-dark">
                                        <i class="fas fa-lightbulb text-warning mr-2"></i>Tips & Info
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info border-0 rounded-lg mb-3">
                                        <div class="d-flex">
                                            <div class="alert-icon mr-3">
                                                <i class="fas fa-info-circle text-info fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="alert-heading mb-1">Optimalkan Inventori</h6>
                                                <p class="mb-0 small">Pastikan stok obat selalu terupdate untuk menghindari kekurangan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-success border-0 rounded-lg mb-3">
                                        <div class="d-flex">
                                            <div class="alert-icon mr-3">
                                                <i class="fas fa-check-circle text-success fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="alert-heading mb-1">Backup Data</h6>
                                                <p class="mb-0 small">Lakukan backup data secara berkala untuk keamanan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning border-0 rounded-lg">
                                        <div class="d-flex">
                                            <div class="alert-icon mr-3">
                                                <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="alert-heading mb-1">Update Sistem</h6>
                                                <p class="mb-0 small">Pastikan sistem selalu up-to-date dengan versi terbaru.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Gradient Background */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Hover Effects */
.hover-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
}

/* Action Cards */
.action-card {
    transition: all 0.3s ease;
    border: 2px solid #f8f9fa !important;
}

.action-card:hover {
    border-color: #007bff !important;
    background-color: #f8f9ff;
}

/* Activity Icons */
.activity-icon {
    transition: all 0.3s ease;
}

.activity-item:hover .activity-icon {
    transform: scale(1.1);
}

/* Rounded Corners */
.rounded-lg {
    border-radius: 12px !important;
}

/* Custom Shadows */
.shadow-sm {
    box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
}

/* Hero Icon Animation */
.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }

    .hero-icon i {
        font-size: 3rem;
    }

    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
// Simple Sales Chart using AmCharts (already included in layout)
document.addEventListener('DOMContentLoaded', function() {
    // Sample data - you can replace with real data from backend
    var chartData = [
        { month: 'Jan', sales: 120 },
        { month: 'Feb', sales: 150 },
        { month: 'Mar', sales: 180 },
        { month: 'Apr', sales: 200 },
        { month: 'May', sales: 170 },
        { month: 'Jun', sales: 220 }
    ];

    var chart = AmCharts.makeChart("salesChart", {
        "type": "serial",
        "theme": "light",
        "dataProvider": chartData,
        "valueAxes": [{
            "gridColor": "#FFFFFF",
            "gridAlpha": 0.2,
            "dashLength": 0
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
            "balloonText": "[[category]]: <b>[[value]]</b>",
            "fillAlphas": 0.8,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "sales",
            "fillColors": "#667eea",
            "lineColor": "#667eea"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "month",
        "categoryAxis": {
            "gridPosition": "start",
            "gridAlpha": 0,
            "tickPosition": "start",
            "tickLength": 20
        },
        "export": {
            "enabled": false
        }
    });
});
</script>
@endsection