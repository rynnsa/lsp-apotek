<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Data Penjualan</h4>
                        </div>
                    </div>
                    <div class="card-block py-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari transaksi...">
                                    <button class="btn" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterStatus" class="form-select form-control rounded-3 custom-select ">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No resi</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        {{-- <th>Total Harga</th> --}}
                                        <th>Pengiriman</th>
                                        {{-- <th>Biaya Pengiriman</th> --}}
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Resep</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($penjualans as $penjualan)
                                    <tr>
                                        {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                        <td>{{ $penjualan->no_resi }}</td>
                                        <td>{{ $penjualan->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                        {{-- <td>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td> --}}
                                        <td>{{ $penjualan->jenis_pengiriman->jenis_kirim }}</td>
                                        {{-- <td>Rp {{ number_format($penjualan->biaya_pengiriman, 0, ',', '.') }}</td> --}}
                                        <td>{{ $penjualan->metode_bayar->metode_pembayaran }}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <ul>
                                                    <span class="badge py-2 px-3 rounded-pill text-white
                                                        @if($penjualan->status_order == 'Menunggu Konfirmasi') bg-secondary
                                                        @elseif($penjualan->status_order == 'Diproses') bg-info
                                                        @elseif($penjualan->status_order == 'Dikirim') bg-primary
                                                        @elseif($penjualan->status_order == 'Menunggu Kurir') bg-warning
                                                        @elseif($penjualan->status_order == 'Diterima') bg-success
                                                        @elseif($penjualan->status_order == 'Batal') bg-danger
                                                        @elseif($penjualan->status_order == 'Selesai') bg-success
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $penjualan->status_order }}
                                                    </span>
                                                </ul>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td class="align-middle">
                                            <button class="btn btn-info btn-sm ti-info-alt" data-bs-toggle="modal" data-bs-target="#detailModal{{ $penjualan->id }}">
                                            </button>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline rounded-pill">
                                                 <select class="form-select form-control rounded-3 custom-select rounded-pill" onchange="updateStatus({{ $penjualan->id }}, this.value)">
                                                    <option value="Menunggu Konfirmasi" {{ $penjualan->status_order == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                    <option value="Diproses" {{ $penjualan->status_order == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Menunggu Kurir" {{ $penjualan->status_order == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                                                    <option value="Selesai" {{ $penjualan->status_order == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Dibatalkan Penjual" {{ $penjualan->status_order == 'Dibatalkan Penjual' ? 'selected' : '' }}>Dibatalkan Penjual</option>
                                                    <option value="Bermasalah" {{ $penjualan->status_order == 'Bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data penjualan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        @foreach($penjualans as $penjualan)
                        <div class="modal fade" id="detailModal{{ $penjualan->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail penjualan - No resi ({{ $penjualan->no_resi }} )</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                        <th>Ongkos Kirim</th>
                                                        <th>Biaya App</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($penjualan->detail_penjualans as $detail)
                                                    @php
                                                        $subtotal = $detail->harga_beli * $detail->jumlah_beli;
                                                        $total_items = $penjualan->detail_penjualans->sum(function($item) {
                                                            return $item->harga_beli * $item->jumlah_beli;
                                                        });
                                                        $total_bayar = $total_items + $penjualan->jenis_pengiriman->ongkos_kirim + $penjualan->biaya_app;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $detail->obat->nama_obat }}</td>
                                                        <td>{{ $detail->jumlah_beli }}</td>
                                                        <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($penjualan->jenis_pengiriman->ongkos_kirim, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada detail penjualan</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                         <th colspan="6" class="text-end">Total Bayar:</th>
                                                        <th colspan="3">Rp {{ number_format($total_bayar, 0, ',', '.') }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedStatus = filterStatus.value;

        tableRows.forEach(row => {
            const pelanggan = row.children[2].textContent.toLowerCase();
            const status = row.children[6].textContent.trim().toLowerCase();
            
            const matchSearch = pelanggan.includes(searchTerm);
            const matchStatus = selectedStatus === '' || status === selectedStatus.toLowerCase();

            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterStatus.addEventListener('change', filterTable);
});

function showDetail(id) {
    fetch(`/penjualan/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('noResi').textContent = data.no_resi;
            document.getElementById('namaPelanggan').textContent = data.pelanggan.nama_pelanggan;
            document.getElementById('tanggalPenjualan').textContent = new Date(data.tgl_penjualan).toLocaleDateString('id-ID');
            document.getElementById('statusPenjualan').textContent = data.status_order;
            document.getElementById('metodePembayaran').textContent = data.metode_bayar.metode_pembayaran;
            document.getElementById('jenisPengiriman').textContent = data.jenis_pengiriman.jenis_kirim;

            const tbody = document.getElementById('detailTableBody');
            tbody.innerHTML = '';
            let subtotal = 0;

            data.detail_penjualans.forEach((item, index) => {
                const itemSubtotal = item.jumlah_beli * item.obat.harga_jual;
                subtotal += itemSubtotal;
                
                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.obat.nama_obat}</td>
                        <td>Rp ${numberFormat(item.obat.harga_jual)}</td>
                        <td>${item.jumlah_beli}</td>
                        <td>Rp ${numberFormat(itemSubtotal)}</td>
                    </tr>
                `;
            });

            document.getElementById('subtotal').textContent = `Rp ${numberFormat(subtotal)}`;
            document.getElementById('ongkosKirim').textContent = `Rp ${numberFormat(data.jenis_pengiriman.ongkos_kirim)}`;
            document.getElementById('biayaApp').textContent = 'Rp 1.000';
            
            const total = subtotal + data.jenis_pengiriman.ongkos_kirim + 1000;
            document.getElementById('totalHarga').textContent = `Rp ${numberFormat(total)}`;

            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail penjualan');
        });
}

function numberFormat(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function updateStatus(id, status) {
    if (!confirm('Apakah Anda yakin ingin mengubah status menjadi ' + status + '?')) {
        return;
    }

    fetch(`/penjualan/update-status/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Gagal mengubah status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
    });
}
</script>

