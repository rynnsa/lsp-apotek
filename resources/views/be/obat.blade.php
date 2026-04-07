<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Daftar Obat</h4>
                            <span>Klik 'Tambah +' untuk menambahkan obat</span>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            Tambah +
                        </button>
                    </div>
                    <div class="card-block py-2"> <!-- Changed padding -->
                        <!-- Add search and filter -->
                        <div class="row mb-2"> <!-- Reduced margin -->
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari obat...">
                                    <button class="btn" type="button" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterObat" class="form-select form-control rounded-3 custom-select">
                                    <option value="">Semua Jenis Obat</option>
                                    <option value="Obat Bebas">Obat Bebas</option>
                                    <option value="Obat Keras">Obat Keras</option>
                                    <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Obat</th>
                                        <th> ID Jenis</th>
                                        <th>Harga Jual</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($obats as $obat)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $obat->foto1) }}" alt="Foto 1" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                </div>
                                                @if($obat->foto2)
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $obat->foto2) }}" alt="Foto 2" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                </div>
                                                @endif
                                                @if($obat->foto3)
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $obat->foto3) }}" alt="Foto 3" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageModal"> 
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->jenis_obat->jenis }}</td>
                                        <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                                        <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">{{$obat->deskripsi_obat}}</td>
                                        <td>{{ $obat->stok }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$obat->id}}">
                                            </button>
                                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                </button>
                                            </form>
                                        </td>
                                    <!-- Add Edit Modal -->
                                    <div class="modal fade" id="editModal{{$obat->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Obat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Obat</label>
                                                            <input type="text" class="form-control" name="nama_obat" value="{{ $obat->nama_obat }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Obat</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="id_jenis" required>
                                                                @foreach($jenis_obats as $jenis)
                                                                    <option value="{{ $jenis->id }}" {{ $obat->id_jenis == $jenis->id ? 'selected' : '' }}>
                                                                        {{ $jenis->jenis }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Harga Beli</label>
                                                            <input type="number" class="form-control harga_beli_edit" onchange="hitungHargaJualEdit(this)" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Margin (%)</label>
                                                            <input type="number" class="form-control margin_edit" value="20" onchange="hitungHargaJualEdit(this)" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Harga Jual</label>
                                                            <input type="number" class="form-control harga_jual_edit" name="harga_jual" value="{{ $obat->harga_jual }}" readonly required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Keuntungan (Rp)</label>
                                                            <input type="number" class="form-control keuntungan_edit" readonly required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi Obat</label>
                                                            <textarea class="form-control" name="deskripsi_obat" rows="3" required>{{ $obat->deskripsi_obat }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Foto 1</label>
                                                            <input type="file" class="form-control" name="foto1" value="{{ $obat->foto1 }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Foto 2</label>
                                                            <input type="file" class="form-control" name="foto2" value="{{ $obat->foto2 }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Foto 3</label>
                                                            <input type="file" class="form-control" name="foto3" value="{{ $obat->foto3 }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Stok</label>
                                                            <input type="number" class="form-control" name="stok" value="{{ $obat->stok }}" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Obat -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" name="nama_obat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Obat</label>
                        <select class="form-select form-control rounded-3 custom-select" name="id_jenis" required>
                            @foreach($jenis_obats as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" name="harga_beli" id="harga_beli_add" onchange="hitungHargaJual()" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">margin (%)</label>
                        <input type="number" class="form-control" name="margin" id="margin_add" value="20" onchange="hitungHargaJual()" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" name="harga_jual" id="harga_jual_add" readonly required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keuntungan (Rp)</label>
                        <input type="number" class="form-control" name="keuntungan" id="keuntungan_add" readonly required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Obat</label>
                        <textarea class="form-control" name="deskripsi_obat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto 1</label>
                        <input type="file" class="form-control" name="foto1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto 2</label>
                        <input type="file" class="form-control" name="foto2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto 3</label>
                        <input type="file" class="form-control" name="foto3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Image Modal for preview -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem; cursor: pointer;"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Image preview functionality
    document.querySelectorAll('.img-thumbnail').forEach(image => {
        image.addEventListener('click', function() {
            document.getElementById('previewImage').src = this.src;
        });
    });

    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterObat = document.getElementById('filterObat');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedJenis = filterObat.value.toLowerCase();

            tableRows.forEach(row => {
                const namaObat = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const jenisObat = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                const matchSearch = namaObat.includes(searchTerm);
                const matchJenis = selectedJenis === '' || jenisObat.includes(selectedJenis);

                if (matchSearch && matchJenis) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Add input event listeners
        searchInput.addEventListener('input', filterTable);
        filterObat.addEventListener('change', filterTable);

        // Initial filter
        filterTable();
    });

    function showMarginModal(namaObat, hargaJual) {
        document.getElementById('namaObat').value = namaObat;
        document.getElementById('hargaJual').value = hargaJual;
    }

    function hitungMargin() {
        const hargaBeli = parseFloat(document.getElementById('hargaBeli').value) || 0;
        const marginPersen = parseFloat(document.getElementById('marginPersen').value) || 0;
        
        const marginRupiah = hargaBeli * (marginPersen / 100);
        const hargaJual = hargaBeli + marginRupiah;
        
        document.getElementById('hargaJual').value = Math.round(hargaJual);
        document.getElementById('keuntungan').value = Math.round(marginRupiah);
    }

    function terapkanHarga() {
        const namaObat = document.getElementById('namaObat').value;
        const hargaJual = parseInt(document.getElementById('hargaJual').value);
        const tr = document.querySelector(`td:contains('${namaObat}')`).closest('tr');
        const id = tr.querySelector('[data-bs-target^="#editModal"]').getAttribute('data-bs-target').replace('#editModal', '');

        fetch(`/obat/update-harga/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                harga_jual: hargaJual
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update form price
                const editForm = document.querySelector(`#editModal${id}`);
                if (editForm) {
                    editForm.querySelector('input[name="harga_jual"]').value = hargaJual;
                }

                // Update displayed price
                const priceCell = tr.querySelector('td:nth-child(5)');
                if (priceCell) {
                    priceCell.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(hargaJual)}`;
                }

                // Close modal and show success message
                $('#marginModal').modal('hide');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Harga jual berhasil diperbarui',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Optional: Reload page to ensure everything is updated
                    // window.location.reload();
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: error.message || 'Gagal memperbarui harga jual'
            });
        });
    }

    function hitungHargaJual() {
        const hargaBeli = parseFloat(document.getElementById('harga_beli_add').value) || 0;
        const marginPersen = parseFloat(document.getElementById('margin_add').value) || 0;
        
        const marginRupiah = hargaBeli * (marginPersen / 100);
        const hargaJual = hargaBeli + marginRupiah;
        
        document.getElementById('harga_jual_add').value = Math.round(hargaJual);
        document.getElementById('keuntungan_add').value = Math.round(marginRupiah);
    }

    function hitungHargaJualEdit(element) {
        // Find the closest modal parent
        const modal = element.closest('.modal-body');
        const hargaBeli = parseFloat(modal.querySelector('.harga_beli_edit').value) || 0;
        const marginPersen = parseFloat(modal.querySelector('.margin_edit').value) || 0;
        
        const marginRupiah = hargaBeli * (marginPersen / 100);
        const hargaJual = hargaBeli + marginRupiah;
        
        modal.querySelector('.harga_jual_edit').value = Math.round(hargaJual);
        modal.querySelector('.keuntungan_edit').value = Math.round(marginRupiah);
    }

    // Initialize calculation when page loads
    document.addEventListener('DOMContentLoaded', function() {
        hitungHargaJual();
    });
</script>

