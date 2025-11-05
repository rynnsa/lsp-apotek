<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail Pesanan #{{ $penjualan->nomor_pesanan }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="mb-2">Informasi Pesanan</h6>
                <p class="mb-1">Tanggal: {{ $penjualan->created_at->format('d M Y H:i') }}</p>
                <p class="mb-1">Status: 
                    <span class="badge 
                        @if($penjualan->status == 'Menunggu Konfirmasi') bg-warning
                        @elseif($penjualan->status == 'Diproses') bg-info
                        @elseif($penjualan->status == 'Menunggu Kurir') bg-primary
                        @elseif($penjualan->status == 'Selesai') bg-success
                        @else bg-danger
                        @endif">
                        {{ $penjualan->status }}
                    </span>
                </p>
                <p class="mb-1">Metode Pembayaran: {{ $penjualan->metode_pembayaran }}</p>
            </div>
        </div>

        <h6 class="mb-3">Detail Produk</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail_penjualans as $detail)
                    <tr>
                        <td>{{ $detail->obat->nama_obat }}</td>
                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
</div>
