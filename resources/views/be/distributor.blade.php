<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Daftar Distributor</h4>
                            <span>Klik 'Tambah +' untuk menambahkan distributor</span>
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
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari distributor...">
                                    <button class="btn" type="button" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>   
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Distributor</th>
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($distributors as $distributor)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{ $distributor->nama_distributor }}</td>
                                        <td class="align-middle">{{$distributor->telepon}}</td>
                                        <td class="align-middle" style="max-width: 250px; white-space: normal; word-wrap: break-word;">{{ $distributor->alamat}}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$distributor->id}}">
                                            </button>
                                            <form action="{{ route('distributor.destroy', $distributor->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{$distributor->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Distributor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('distributor.update', $distributor->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Distributor</label>
                                                            <input type="text" class="form-control" name="nama_distributor" value="{{ $distributor->nama_distributor}}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">No Telepon</label>
                                                            <input class="form-control" name="telepon" value="{{$distributor->telepon}}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alamat</label>
                                                            <textarea class="form-control" name="alamat" rows="3">{{ $distributor->alamat}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
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

<!-- Modal Tambah distributor -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah distributor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('distributor.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama distributor</label>
                        <input type="text" class="form-control @error('nama_distributor') is-invalid @enderror" 
                               name="nama_distributor" value="{{ old('nama_distributor') }}" required>
                        @error('nama_distributor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input class="form-control" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
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
        const tableRows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', filterTable);
    });
</script>
