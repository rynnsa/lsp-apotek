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
                <div class="d-flex justify-content-center mb-3">
                    <div class="d-flex gap-2">
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
                                    class="btn btn-sm rounded-pill btn-primary py-1 px-4 text-white" style="font-size: 12px;" id="snap-token">
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
                                    <th>Keterangan</th>
                                    <th>Resep</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penjualan->detail_penjualans as $detail)
                                <tr>
                                    <td class="align-middle text-center" style="width: 100px;">
                                        <img src="{{ asset('storage/' . $detail->obat->foto1) }}" alt="{{ $detail->obat->nama_obat }}" style="width: 50px; height: 50px; object-fit: cover;"  class="rounded-pill">
                                    </td>
                                    <td class="align-middle">{{ $detail->obat->nama_obat }}</td>
                                    <td class="align-middle">{{ $detail->jumlah_beli }}x</td>
                                    <td class="align-middle">Rp {{ number_format($detail->obat->harga_jual * $detail->jumlah_beli, 0, ',', '.') }}</td>
                                    <td class="align-middle">{{ $penjualan->metode_bayar->metode_pembayaran }}</td>
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
                                    <td class="align-middle" style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                                            @if($penjualan->status_order == 'Menunggu Konfirmasi')
                                                Pemesanan akan diproses setelah melakukan pembayaran
                                            @elseif($penjualan->status_order == 'Diproses')
                                                Pesanan sedang diproses
                                            @elseif($penjualan->status_order == 'Menunggu Kurir')
                                                Pengiriman akan segera dilakukan oleh kurir
                                            @elseif($penjualan->status_order == 'Selesai')
                                                Pesanan telah diterima oleh pelanggan
                                            @elseif($penjualan->status_order == 'Dibatalkan Pembeli')
                                                {{ $penjualan->keterangan_status }}
                                            @else
                                                Pesanan Bermasalah silahkan hubungi admin kami <br> <a href="mailto:alifecareyou@gmail.com" target="_blank">alifecareyou@gmail.com</a>
                                            @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($penjualan->url_resep)
                                            <img src="{{ asset('storage/' . $penjualan->url_resep) }}" alt="Resep" class="img-thumbnail mt-1" style="width: 80px;">
                                        @else
                                            <span class="fst-italic text-muted">Tidak ada resep</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center px-3 py-2">
                            <div>
                                @if(!$hideButtons)
                                    <a href="javascript:void(0)" onclick="cancelOrder({{ $penjualan->id }})"
                                    class="btn btn-sm rounded-pill btn-danger py-1 px-4 text-white" style="font-size: 12px;">
                                        Batalkan Pesanan
                                    </a>
                                    
                                @endif
                            </div>
                            <div>
                                @php
                                    $subtotal = $penjualan->detail_penjualans->sum(function($detail) {
                                        return $detail->jumlah_beli * $detail->obat->harga_jual;
                                    });
                                    $penjualan->biaya_app = $subtotal * 0.09; // You can adjust this value or fetch from settings
                                    $total_bayar = $subtotal + $penjualan->jenis_pengiriman->ongkos_kirim + $penjualan->biaya_app;
                                @endphp
                                <div class="text-end">
                                    <div class="text-muted">
                                        <small>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</small><br>
                                        <small>Ongkos Kirim: Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</small><br>
                                        <small>Biaya Aplikasi: Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="fw-bold text-primary mt-1">
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
    .btn-outline-danger:hover, .btn-outline-danger.active {
        background-color: var(--bs-danger) !important;
        color: white !important;
    }
    .btn-outline-warning {
        color: #6c757d !important;
        border-color: #6c757d !important;
    }
    .btn-outline-warning:hover, .btn-outline-warning.active {
        background-color: #6c757d !important;
        color: white !important;
    }
    .btn-outline-secondary:hover, .btn-outline-secondary.active {
        background-color: #fbbd00 !important;
        color: white !important;
    }

    .btn-outline-info:hover, .btn-outline-info.active {
        background-color: var(--bs-info) !important;
        color: white !important;
    }
    .btn-outline-success:hover, .btn-outline-success.active {
        background-color: var(--bs-success) !important;
        color: white !important;
    }

    .small-popup {
    max-width: 400px !important;
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

