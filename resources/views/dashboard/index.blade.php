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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection