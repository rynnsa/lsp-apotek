@extends('be.layouts.main')

@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">daftar Jenis Obat</h4>
                            <span>Klik 'Tambah +' untuk menambahkan jenis obat</span>
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
                                        <th>Foto</th>
                                        <th>Jenis</th>
                                        <th>Deskripsi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenis_obats as $jenisobat)
                                        <tr>                                                                                                             
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                            <td class="align-middle">
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $jenisobat->image_url) }}" alt="image jenis" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal"  data-bs-target="#imageModal" onclick="showImage(this.src)">
                                                </div>
                                            </td>
                                            <td class="align-middle">{{$jenisobat->jenis}}</td>
                                            <td class="align-middle" style="max-width: 250px; white-space: normal; word-wrap: break-word;">{{$jenisobat->deskripsi_jenis}}</td>
                                            <td class="align-middle">
                                                <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$jenisobat->id}}">
                                                </button>
                                                <form action="{{ route('jenisobat.destroy', $jenisobat->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{$jenisobat->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Jenis Obat</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('jenisobat.update', $jenisobat->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Jenis Obat</label>
                                                                <input type="text" class="form-control" name="jenis" value="{{ $jenisobat->jenis }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Deskripsi Jenis</label>
                                                                <textarea class="form-control" name="deskripsi_jenis" rows="3" required>{{ $jenisobat->deskripsi_jenis }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Foto</label>
                                                                <input type="file" class="form-control" name="image_url">
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
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Jenis Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('jenisobat.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Obat</label>
                        <input type="text" class="form-control" name="jenis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Jenis</label>
                        <textarea class="form-control" name="deskripsi_jenis" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto 1</label>
                        <input type="file" class="form-control" name="image_url" required>
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
</script>

    {{-- // Search and filter functionality
    // document.addEventListener('DOMContentLoaded', function() {
    //     const searchInput = document.getElementById('searchInput');
    //     const filterJenis = document.getElementById('filterJenis');
    //     const tableRows = document.querySelectorAll('tbody tr');

    //     function filterTable() {
    //         const searchTerm = searchInput.value.toLowerCase();
    //         const selectedJenis = filterJenis.value.toLowerCase();

    //         tableRows.forEach(row => {
    //             const namaObat = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
    //             const jenisObat = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
    //             const matchSearch = namaObat.includes(searchTerm);
    //             const matchJenis = selectedJenis === '' || jenisObat === selectedJenis;

    //             row.style.display = matchSearch && matchJenis ? '' : 'none';
    //         });
    //     }

    //     searchInput.addEventListener('input', filterTable);
    //     filterJenis.addEventListener('change', filterTable);
    // }); {{--
@endsection


