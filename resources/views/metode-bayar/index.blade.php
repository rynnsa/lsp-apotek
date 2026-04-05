@extends('be.master-admin')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">daftar Metode Bayar</h4>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            Tambah +
                        </button>
                    </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tempat Bayar</th>
                                        <th>Nomor Rekening</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($metode_bayars as $metode_bayar)
                                        <tr>                                                                                                             
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                            <td class="align-middle">
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $metode_bayar->url_logo) }}" alt="image logo" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal"  data-bs-target="#imageModal" onclick="showImage(this.src)">
                                                </div>
                                            </td>
                                            <td class="align-middle">{{$metode_bayar->metode_pembayaran}}</td>
                                            <td class="align-middle" style="max-width: 250px; white-space: normal; word-wrap: break-word;">{{$metode_bayar->tempat_bayar}}</td>
                                            <td class="align-middle" style="max-width: 250px; white-space: normal; word-wrap: break-word;">{{$metode_bayar->no_rekening}}</td>

                                            <td class="align-middle">
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$metode_bayar->id}}">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('metodebayar.destroy', $metode_bayar->id) }}" method="POST" class="d-inline delete-form" data-item-name="{{ $metode_bayar->metode_pembayaran }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{$metode_bayar->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Metode Bayar</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('metodebayar.update', $metode_bayar->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Metode Pembayaran</label>
                                                                <input type="text" class="form-control" name="metode_pembayaran" value="{{ $metode_bayar->metode_pembayaran }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tempat Bayar</label>
                                                                <input class="form-control" name="tempat_bayar" value="{{ $metode_bayar->tempat_bayar }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nomor Rekening</label>
                                                                <input class="form-control" name="no_rekening" value="{{ $metode_bayar->no_rekening }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Logo</label>
                                                                <input type="file" class="form-control" name="url_logo">
                                                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
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

<!-- Modal Tambah Obat -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Metode Bayar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('metodebayar.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control" name="metode_pembayaran" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Bayar</label>
                        <input class="form-control" name="tempat_bayar" rows="3" required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" name="no_rekening" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="url_logo" required>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid">
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

    function showImage(src) {
        document.getElementById('previewImage').src = src;
    }

     // Search and filter functionality
     document.addEventListener('DOMContentLoaded', function() {
         const searchInput = document.getElementById('searchInput');
         const filterJenis = document.getElementById('filterJenis');
         const tableRows = document.querySelectorAll('tbody tr');

         function filterTable() {
             const searchTerm = searchInput.value.toLowerCase();
             const selectedJenis = filterJenis.value.toLowerCase();

             tableRows.forEach(row => {
                 const namaObat = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                 const metode_bayar = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                 const matchSearch = namaObat.includes(searchTerm);
                 const matchJenis = selectedJenis === '' || metode_bayar === selectedJenis;

                 row.style.display = matchSearch && matchJenis ? '' : 'none';
             });
         }

         searchInput.addEventListener('input', filterTable);
         filterJenis.addEventListener('change', filterTable);
     }); 

    // SweetAlert2 Delete Confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const itemName = this.getAttribute('data-item-name');
                
                Swal.fire({
                    title: 'Hapus Metode Bayar?',
                    html: `<span class="text-dark">Apakah Anda yakin ingin menghapus metode pembayaran <strong>${itemName}</strong>?</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });

</script>

@endsection