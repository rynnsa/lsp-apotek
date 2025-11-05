
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Hover table card start -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-pengirimans-center">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div>
                            <h4 class="mb-0">Kelola Pengiriman</h4>
                        </div>
                       
                        <div class="d-flex justify-content-end gap-2">
                            <a href="#" class="btn btn-primary text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahPengirimanModal">
                                Tambah +
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-block">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari pengiriman...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterStatus" class="form-select form-control rounded-2 custom-select">
                                    <option value="">Semua Status</option>
                                    <option value="Sedang Dikirim"> Sedang Dikirim</option>
                                    <option value="Tiba Ditujuan">Tiba Ditujuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penjualan</th>
                                        <th>Nama Kurir</th>
                                        <th>No Invoice</th>
                                        <th>Status pengiriman</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengirimans as $pengiriman)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td style="white-space: normal; word-wrap: break-word; max-width: 300px;">
                                            <strong>Resi:</strong> {{ $pengiriman->penjualan->no_resi }} <br>
                                            <strong>Nama:</strong> {{ $pengiriman->penjualan->pelanggan->nama_pelanggan }} <br>
                                            <strong>Alamat:</strong> {{ $pengiriman->penjualan->pelanggan->alamat1}}
                                        </td>
                                        <td class="align-middle">{{ $pengiriman->nama_kurir }}</td>
                                        <td class="align-middle">{{ $pengiriman->no_invoice }}</td>
                                        <td class="align-middle py-2 px-3">
                                            <span class="badge 
                                                @if($pengiriman->status_kirim == 'Sedang Dikirim') bg-warning
                                                @elseif($pengiriman->status_kirim == 'Tiba Ditujuan') bg-success
                                                @else bg-danger
                                                @endif">
                                                {{ $pengiriman->status_kirim }}
                                            </span>
                                        </td>
                                        <td class="align-middle"><i>{{ $pengiriman->keterangan ?? 'Kurir belum konfirmasi' }}</i></td>
                                        <td class="align-middle">
                                            <button class="btn btn-info btn-sm ti-info-alt" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pengiriman->id }}">
                                            </button>
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$pengiriman->id}}">
                                            </button>
                                            <form action="{{ route('pengiriman.destroy', $pengiriman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                         <!-- Modal detail -->
                         @foreach($pengirimans as $pengiriman)
                        <div class="modal fade" id="detailModal{{ $pengiriman->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail pengiriman - Resi: ({{ $pengiriman->penjualan->no_resi }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th width="30%">Tanggal Kirim</th>
                                                    <td>{{ $pengiriman->tgl_kirim }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Tiba</th>
                                                    <td>{{ $pengiriman->tgl_tiba ?? 'Kurir belum konfirmasi' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Telepon Kurir</th>
                                                    <td>{{ $pengiriman->telpon_kurir ?? 'Kurir belum konfirmasi' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Bukti Pengiriman</th>
                                                    <td>
                                                        @if ($pengiriman->bukti_foto)
                                                            <img src="{{ asset('storage/' . $pengiriman->bukti_foto) }}" 
                                                                alt="Bukti foto" class="img-fluid" style="max-width: 200px;">
                                                        @else
                                                            Kurir belum konfirmasi
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <td>{{ $pengiriman->keterangan ?? 'Kurir belum konfirmasi' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal update -->
                        @foreach($pengirimans as $pengiriman)
                        <div class="modal fade" id="editModal{{ $pengiriman->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pengiriman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('pengiriman.update', $pengiriman->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Status Pengiriman</label>
                                                <select class="form-select form-control rounded-3 custom-select" name="status_kirim" required>
                                                    <option value="Sedang Dikirim" {{ $pengiriman->status_kirim == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                                    <option value="Tiba Ditujuan" {{ $pengiriman->status_kirim == 'Tiba Ditujuan' ? 'selected' : '' }}>Tiba Ditujuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Tiba</label>
                                                <input type="date" class="form-control" name="tgl_tiba" value="{{ $pengiriman->tgl_tiba }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bukti Foto</label>
                                                <input type="file" class="form-control" name="bukti_foto">
                                                @if($pengiriman->bukti_foto)
                                                    <img src="{{ asset('storage/'.$pengiriman->bukti_foto) }}" class="mt-2" style="max-height: 100px">
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea class="form-control" name="keterangan" rows="3">{{ $pengiriman->keterangan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" id="showAlert{{ $pengiriman->id }}">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </div>
                <!-- Hover table card end -->
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    <div id="styleSelector"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('[id^="showAlert"]');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pengiriman berhasil diperbarui.',
                    icon: 'success',
                    confirmButtonText: false
                });
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filterStatus');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = filterStatus.value.toLowerCase();

            tableRows.forEach(row => {
                const noInvoice = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const status = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                const matchSearch = noInvoice.includes(searchTerm);
                const matchStatus = selectedStatus === '' || status === selectedStatus;

                row.style.display = matchSearch && matchStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
    });
</script>

