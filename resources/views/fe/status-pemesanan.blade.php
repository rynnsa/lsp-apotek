{{-- <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="javascript:history.back()" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center ms-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-arrow-left text-white"></i>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                </nav>
            </div>
        </div>
        <!-- Navbar End --> --}}

        <!-- Single Page Header start -->
        <div class="container-fluid py-5 mt-4">
        </div>
        <!-- Single Page Header End -->

        <!-- Status Pemesanan Start -->
        <div class="container-fluid py-5">
            <div class="container py-3">
            <h1 class="mb-3"> </h1>
                <div class="d-flex mb-3">
                    <div class="d-flex gap-2 mb-3 justify-content-center">
                        <button class="btn btn-outline-danger text-danger bg-white rounded-pill py-1 px-4" onclick="filterStatus('Batal')">Dibatalkan</button>
                        <button class="btn btn-outline-warning text-warning bg-white rounded-pill py-1 px-4" onclick="filterStatus('Menunggu Konfirmasi')">Belum Bayar</button>
                        <button class="btn btn-outline-secondary text-secondary bg-white rounded-pill py-1 px-4" onclick="filterStatus('Diproses')">Diproses</button>
                        <button class="btn btn-outline-info text-info bg-white rounded-pill py-1 px-4" onclick="filterStatus('Dikirim')">Dikirim</button>
                        <button class="btn btn-outline-success text-success bg-white rounded-pill py-1 px-4" onclick="filterStatus('Selesai')">Selesai</button>
                    </div>
                </div>
                @forelse($penjualans as $penjualan)
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-white border-bottom border-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $penjualan->tgl_penjualan->format('d, F Y') }} - {{ $penjualan->no_resi }}</strong>  
                            @php
                                $total_bayar = $penjualan->detail_penjualans->sum(function($detail) {
                                    return $detail->jumlah_beli * $detail->obat->harga_jual;
                                }) + $penjualan->jenis_pengiriman->ongkos_kirim + 1000;
                                $hideButtons = in_array($penjualan->status_order, ['Diproses', 'Menunggu Kurir', 'Selesai', 'Dibatalkan Penjual', 'Dibatalkan Pembeli']);
                            @endphp
                            @if(!$hideButtons) 
                                <a href="javascript:void(0)" onclick="bayarSekarang('{{ $penjualan->id }}', {{ $total_bayar }})"
                                    class="btn btn-sm rounded-lg btn-primary py-1 px-4 text-white" style="font-size: 12px;" id="snap-token">
                                    <i class="fa fa-credit-card me-1"></i>  
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th></th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah beli</th>
                                    <th>Harga</th>
                                    <th>Pembayaran</th>
                                    <th>Status Pemesanan</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th>Resep</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penjualan->detail_penjualans as $detail)
                                <tr>
                                    <td class="align-middle text-center" style="width: 100px;">
                                        <img src="{{ asset('storage/' . $detail->obat->foto1) }}" alt="{{ $detail->obat->nama_obat }}" style="width: 50px; height: 50px; object-fit: cover;"  class="rounded-pill">
                                    </td>
                                    <td class="align-middle" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ $detail->obat->nama_obat }}</td>
                                    <td class="align-middle text-center">{{ $detail->jumlah_beli }}x</td>
                                    <td class="align-middle" style="white-space: nowrap;">Rp {{ number_format($detail->obat->harga_jual * $detail->jumlah_beli, 0, ',', '.') }}</td>
                                    <td class="align-middle" style="max-width: 120px; overflow: hidden; text-overflow: ellipsis;">{{ $penjualan->metode_bayar->metode_pembayaran }}</td>
                                    <td class="align-middle">
                                        <span class="badge py-2 px-3 rounded-pill text-white 
                                            @if($penjualan->status_order == 'Menunggu Konfirmasi') bg-secondary
                                            @elseif($penjualan->status_order == 'Diproses') bg-info
                                            @elseif($penjualan->status_order == 'Dikirim') bg-primary
                                            @elseif($penjualan->status_order == 'Menunggu Kurir') bg-warning
                                            @elseif($penjualan->status_order == 'Diterima') bg-success
                                            @elseif($penjualan->status_order == 'Batal') bg-danger
                                            @elseif($penjualan->status_order == 'Selesai') bg-success
                                            @else bg-danger
                                            @endif align-middle">
                                            {{ $penjualan->status_order }}
                                        </span>
                                    </td>
                                    {{-- <td class="align-middle" style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                                            @if($penjualan->status_order == 'Menunggu Konfirmasi')
                                                Pemesanan akan diproses setelah melakukan pembayaran
                                            @elseif($penjualan->status_order == 'Diproses')
                                                Pesanan sedang diproses
                                            @elseif($penjualan->status_order == 'Menunggu Kurir')
                                                Pengiriman akan segera dilakukan oleh {{ $penjualan->courier ?? 'kurir' }}
                                            @elseif($penjualan->status_order == 'Selesai')
                                                Pesanan telah diterima oleh pelanggan
                                            @elseif($penjualan->status_order == 'Dibatalkan Pembeli')
                                                {{ $penjualan->keterangan_status }}
                                            @else
                                                Pesanan Bermasalah silahkan hubungi admin kami <br> <a href="mailto:alifecareyou@gmail.com" target="_blank">alifecareyou@gmail.com</a>
                                            @endif
                                    </td> --}}
                                    <td class="align-middle">
                                        @if($penjualan->url_resep)
                                            <img src="{{ asset('storage/' . $penjualan->url_resep) }}" alt="Resep" class="img-thumbnail mt-1" style="width: 80px;">
                                        @else
                                            <span class="fst-italic text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Shipping Address Section -->
                        <div class="px-3 py-3 border-top bg-light">
                            <h6 class="mb-2"><strong>Alamat Pengiriman</strong></h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="mb-1"><span class="text-muted fs-6">Alamat:</span></p>
                                    <p class="mb-2" style="font-size: 15px;">{{ $penjualan->alamat_pengiriman ?? $penjualan->pelanggan->alamat1 }}</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><span class="text-muted fs-6">Kota:</span></p>
                                            <p class="mb-2" style="font-size: 15px;">{{ $penjualan->kota_pengiriman ?? $penjualan->pelanggan->kota1 }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><span class="text-muted fs-6">Provinsi:</span></p>
                                            <p class="mb-2" style="font-size: 15px;">{{ $penjualan->provinsi_pengiriman ?? $penjualan->pelanggan->propinsi1 }}</p>
                                        </div>
                                    </div>
                                    
                                    <p class="mb-1"><span class="text-muted fs-6">Kode Pos:</span></p>
                                    <p class="mb-0" style="font-size: 15px;">{{ $penjualan->kodepos_pengiriman ?? $penjualan->pelanggan->kodepos1 }}</p>
                                </div>
                                <div class="col-md-4">
                                    @if(in_array($penjualan->status_order, ['Menunggu Kurir', 'Selesai']) && $penjualan->courier && $penjualan->pengiriman)
                                        <p class="mb-1"><span class="text-muted fs-6">Kurir:</span></p>
                                        <p class="mb-2"><strong style="font-size: 15px;">{{ strtoupper($penjualan->courier) }} - {{ $penjualan->pengiriman->nama_kurir }}</strong></p>
                                        
                                        <p class="mb-1"><span class="text-muted fs-6">No. Telepon:</span></p>
                                        <p class="mb-2" style="font-size: 15px;">{{ $penjualan->pengiriman->telpon_kurir }}</p>
                                        
                                        @if($penjualan->status_order == 'Selesai' && $penjualan->pengiriman->bukti_foto)
                                            <p class="mb-1"><span class="text-muted fs-6">Bukti Foto:</span></p>
                                            <img src="{{ asset('storage/' . $penjualan->pengiriman->bukti_foto) }}" alt="Bukti Pengiriman" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                        @endif
                                    @elseif(in_array($penjualan->status_order, ['Menunggu Konfirmasi ', 'Diproses']) && $penjualan->pengiriman)
                                        <p class="mb-1"><span class="text-muted fs-6">Kurir:</span></p>
                                        <p class="mb-2"><strong style="font-size: 15px;">{{ $penjualan->pengiriman->nama_kurir }}</strong></p>
                                        
                                        <p class="mb-1"><span class="text-muted fs-6">No. Telepon:</span></p>
                                        <p class="mb-2" style="font-size: 15px;">{{ $penjualan->pengiriman->telpon_kurir }}</p>
                                    @elseif($penjualan->courier)
                                        <p class="mb-1"><span class="text-muted fs-6">Kurir:</span></p>
                                        <p class="mb-2"><strong style="font-size: 15px;">{{ strtoupper($penjualan->courier) }}</strong></p>
                                    @endif
                                    
                                    @if($penjualan->shipping_package)
                                        <p class="mb-1"><span class="text-muted fs-6">Paket:</span></p>
                                        <p class="mb-0" style="font-size: 15px;">{{ $penjualan->shipping_package }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top p-0">
                        <div class="d-flex justify-content-between align-items-center px-3 py-3">
                            <div>
                                @if(!$hideButtons)
                                    <a href="javascript:void(0)" onclick="cancelOrder({{ $penjualan->id }})"
                                    class="btn btn-sm rounded-lg btn-danger py-1 px-4 text-white" style="font-size: 15px;">
                                        Batalkan Pesanan
                                    </a>
                                @endif
                            </div>
                            <div>
                                @php
                                    $subtotal = $penjualan->detail_penjualans->sum(function($detail) {
                                        return $detail->jumlah_beli * $detail->obat->harga_jual;
                                    });
                                    $penjualan->biaya_app = $subtotal * 0.09;
                                    $total_bayar = $subtotal + $penjualan->jenis_pengiriman->ongkos_kirim + $penjualan->biaya_app;
                                @endphp
                                <div class="text-end">
                                    <div class="text-muted">
                                        <span class="fs-6">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</span><br>
                                        <span class="fs-6">Ongkos Kirim: Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</span><br>
                                        <span class="fs-6">Biaya Aplikasi: Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="fw-bold text-primary mt-1 medium">
                                        Total Bayar: Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@empty
<div class="text-center py-4">
    Belum ada pesanan.
</div>
@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="detailContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

 <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>



<script>

function cancelOrder(penjualanId) {
    Swal.fire({
        title: 'Batalkan Pesanan',
        html: `
            <p class="mb-2">Pesanan akan dibatalkan</p>
            <textarea id="cancelReason" 
                class="form-control" 
                rows="2" 
                style="font-size: 13px; margin-top: 10px; max-width: 300px; margin: 0 auto;" 
                placeholder="Masukkan alasan pembatalan..."></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Tidak',
        customClass: {
            popup: 'small-popup'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const reason = document.getElementById('cancelReason').value;
            
            fetch(`/cancel-order/${penjualanId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    keterangan: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Dibatalkan!',
                        'Pesanan telah dibatalkan.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire(
                        'Gagal!',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan saat membatalkan pesanan.',
                    'error'
                );
            });
        }
    });
}
</script>

<script>
function bayarSekarang(penjualanId) {
    fetch(`/midtrans/get-token/${penjualanId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    updateOrderStatus(penjualanId, result);
                },
                onPending: function(result) {
                    Swal.fire('Info', 'Menunggu pembayaran', 'info');
                },
                onError: function(result) {
                    Swal.fire('Error', 'Pembayaran gagal', 'error');
                }
            });
        }
    });
}

function updateOrderStatus(penjualanId, result) {
    fetch(`/midtrans/update-status/${penjualanId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            transaction_status: 'settlement',
            payment_result: result 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Pesanan Anda akan segera diproses',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        }
    });
}
</script>

<style>
    /* Card Consistency Styles */
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 600px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        flex-shrink: 0;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        color: white !important;
        padding: 16px 20px;
        border-bottom: none;
        border-radius: 12px 12px 0 0;
    }

    .card-header strong {
        font-size: 16px;
        font-weight: 600;
    }

    .card-body {
        flex: 0 1 auto;
        overflow-y: auto;
        max-height: 320px;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    .card-body table {
        table-layout: fixed;
        margin-bottom: 0;
        background: transparent;
    }

    .card-body table thead {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #007bff;
        color: white;
    }

    .card-body table thead th {
        padding: 12px 8px;
        font-size: 14px;
        font-weight: 600;
        border: none;
    }

    .card-body table tbody tr {
        height: 75px;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease;
    }

    .card-body table tbody tr:hover {
        background-color: #f1f3f4;
    }

    .card-body table td {
        padding: 12px 8px;
        vertical-align: middle;
        font-size: 14px;
        word-wrap: break-word;
        overflow: hidden;
        border: none;
    }

    .card-body table td:first-child {
        width: 80px;
        text-align: center;
    }

    .card-body img {
        width: 50px !important;
        height: 50px !important;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Shipping Address Section */
    .shipping-address-section {
        flex-shrink: 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-top: 1px solid #dee2e6;
        max-height: 180px;
        overflow-y: auto;
        padding: 16px 20px;
        border-radius: 0 0 12px 12px;
    }

    .shipping-address-section h6 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #495057;
        display: flex;
        align-items: center;
    }

    .shipping-address-section h6::before {
        content: "📍";
        margin-right: 8px;
    }

    .shipping-address-section p {
        margin-bottom: 8px;
        font-size: 14px;
        color: #6c757d;
    }

    .shipping-address-section .text-muted {
        color: #6c757d !important;
    }

    /* Card Footer */
    .card-footer {
        flex-shrink: 0;
        background: #ffffff !important;
        border-top: 1px solid #dee2e6;
        min-height: 90px;
        display: flex;
        align-items: stretch;
        border-radius: 0 0 12px 12px;
        padding: 16px 20px;
    }

    .card-footer .d-flex {
        width: 100%;
        gap: 15px;
    }

    .card-footer .text-end {
        min-width: 250px;
    }

    .card-footer .text-muted span {
        font-size: 14px;
        display: block;
        margin-bottom: 4px;
        color: #6c757d;
    }

    .card-footer .fw-bold {
        font-size: 18px;
        margin-top: 8px;
        color: #007bff;
        font-weight: 700;
    }

    /* Badge Styling */
    .badge {
        font-size: 12px !important;
        white-space: nowrap;
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Button Consistency */
    .btn-sm {
        font-size: 12px;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Filter button styles */
    .btn-outline-danger, .btn-outline-warning, .btn-outline-secondary, .btn-outline-info, .btn-outline-success {
        border-width: 2px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-outline-danger:hover, .btn-outline-danger.active {
        background-color: var(--bs-danger) !important;
        color: white !important;
        border-color: var(--bs-danger) !important;
        transform: translateY(-2px);
    }
    
    .btn-outline-warning {
        color: #6c757d !important;
        border-color: #6c757d !important;
    }
    
    .btn-outline-warning:hover, .btn-outline-warning.active {
        background-color: #6c757d !important;
        color: white !important;
        border-color: #6c757d !important;
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary:hover, .btn-outline-secondary.active {
        background-color: #fbbd00 !important;
        color: white !important;
        border-color: #fbbd00 !important;
        transform: translateY(-2px);
    }

    .btn-outline-info:hover, .btn-outline-info.active {
        background-color: var(--bs-info) !important;
        color: white !important;
        border-color: var(--bs-info) !important;
        transform: translateY(-2px);
    }
    
    .btn-outline-success:hover, .btn-outline-success.active {
        background-color: var(--bs-success) !important;
        color: white !important;
        border-color: var(--bs-success) !important;
        transform: translateY(-2px);
    }

    .small-popup {
        max-width: 400px !important;
    }

    /* Container Styles */
    .container-fluid.py-5 {
        background: white;
        padding: 40px 0;
    }

    .container {
        padding-bottom: 20px;
    }

    /* Filter Buttons Container */
    .d-flex.justify-content-center.mb-3 .d-flex.gap-2 {
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .card {
            min-height: auto;
            margin-bottom: 20px;
        }

        .card-body {
            max-height: 400px;
        }

        .shipping-address-section {
            max-height: none;
        }

        .card-footer .d-flex {
            flex-direction: column;
            gap: 16px;
        }

        .card-footer .text-end {
            min-width: 100%;
            padding-top: 16px;
            border-top: 1px solid #dee2e6;
        }

        .d-flex.justify-content-center.mb-3 .d-flex.gap-2 {
            flex-wrap: wrap;
            padding: 12px 16px;
        }

        .btn-outline-danger, .btn-outline-warning, .btn-outline-secondary, .btn-outline-info, .btn-outline-success {
            margin-bottom: 8px;
        }
    }
</style>

<script>
// Add this function to trigger filter on page load
document.addEventListener('DOMContentLoaded', function() {
    // Change default filter to 'Menunggu Konfirmasi' (Belum Bayar)
    filterStatus('Menunggu Konfirmasi');
});

function showDetail(penjualanId) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const content = document.getElementById('detailContent');
    
    content.innerHTML = `
        <div class="modal-header">
            <h5 class="modal-title">Loading...</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    fetch(`/pesanan/${penjualanId}/detail`)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            content.innerHTML = `
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat memuat detail pesanan
                    </div>
                </div>
            `;
        });
}

function filterStatus(status) {
    // Remove active class from all buttons
    document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
    
    // Add active class to clicked button
    const activeButton = document.querySelector(`[onclick="filterStatus('${status}')"]`);
    if (activeButton) activeButton.classList.add('active');

    // Existing filter logic
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        const statusBadge = card.querySelector('.badge');
        const currentStatus = statusBadge.textContent.trim();
        const paymentMethod = card.querySelector('td:nth-child(5)').textContent.trim(); // Get payment method
        let showCard = false;

        switch(status) {
            case 'Menunggu Konfirmasi':
                showCard = ['Menunggu Konfirmasi'].includes(currentStatus);
                break;
            case 'Diproses':
                // Only show orders with status 'Diproses' and valid payment method
                showCard = currentStatus === 'Diproses' && paymentMethod !== '';
                break;
            case 'Dikirim':
                showCard = ['Menunggu Kurir'].includes(currentStatus);
                break;
            case 'Batal':
                showCard = ['Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah'].includes(currentStatus);
                break;
            case 'Selesai':
                showCard = currentStatus === 'Selesai';
                break;
            case 'all':
                showCard = true;
                break;
        }

        card.style.display = showCard ? '' : 'none';
    });
}
</script>

