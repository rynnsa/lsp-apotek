@extends('be.master-admin')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Hover table card start -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Tim LifeCareYou</h4>
                        </div>
                       
                        <!-- Modal Tambah jenis_pengiriman -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="#" class="btn btn-primary text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahjenis_pengirimanModal">
                                Tambah +
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-block">

                        <!-- Add search and filter -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Ekpedisi...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterJabatan" class="form-select form-select form-control rounded-2 custom-select">
                                    <option value="">Semua Jenis Pengiriman</option>
                                    <option value="ekonomi">Ekonomi</option>
                                    <option value="kargo">Kargo</option>
                                    <option value="reguler">Reguler</option>
                                    <option value="same day">Same Day</option>
                                    <option value="standard">Standard</option>
                                </select>
                            </div>
                        </div>
                        <!-- End search and filter -->
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        {{-- <th>Nama Ekspedisi</th> --}}
                                        <th>Jenis Pengiriman</th>
                                        <th>Ongkos Kirim</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($jenis_pengirimans as $jenis_pengiriman)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td class="align-middle">
                                            @if($jenis_pengiriman->logo_expedisi)
                                                <img src="{{ asset('uploads/logo_expedisi/' . $jenis_pengiriman->logo_expedisi) }}" 
                                                     alt="Logo {{ $jenis_pengiriman->nama_expedisi }}"
                                                     style="max-width: 50px; height: auto;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        {{-- <td class="align-middle">{{ $jenis_pengiriman->nama_expedisi }}</td> --}}
                                        <td class="align-middle">{{ $jenis_pengiriman->jenis_kirim }}</td>
                                        <td class="align-middle">Rp {{ number_format($jenis_pengiriman->ongkos_kirim, 0, ',', '.') }}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$jenis_pengiriman->id}}">
                                            </button>
                                            <form action="{{ route('jenispengiriman.destroy', $jenis_pengiriman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                </button>
                                            </form>
                                        </td>   
                                    </tr>
                                    
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{$jenis_pengiriman->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-3 border border-primary">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Jenis Pengiriman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('jenispengiriman.update', $jenis_pengiriman->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Ekspedisi</label>
                                                            <input type="text" class="form-control" name="nama_expedisi" value="{{ $jenis_pengiriman->nama_expedisi }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Pengiriman</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="jenis_kirim" required>
                                                                <option value="ekonomi" {{ $jenis_pengiriman->jenis_kirim == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                                <option value="kargo" {{ $jenis_pengiriman->jenis_kirim == 'kargo' ? 'selected' : '' }}>Kargo</option>
                                                                <option value="reguler" {{ $jenis_pengiriman->jenis_kirim == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                                                <option value="same day" {{ $jenis_pengiriman->jenis_kirim == 'same day' ? 'selected' : '' }}>Same Day</option>
                                                                <option value="standard" {{ $jenis_pengiriman->jenis_kirim == 'standard' ? 'selected' : '' }}>Standard</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Ongkos Kirim</label>
                                                            <input type="number" class="form-control" name="ongkos_kirim" value="Rp {{ number_format($jenis_pengiriman->ongkos_kirim, 2, ',', '.') }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Logo</label>
                                                            <input type="file" class="form-control" name="logo_expedisi">
                                                            @if($jenis_pengiriman->logo_expedisi)
                                                                <img src="{{ asset('uploads/logo_expedisi/'.$jenis_pengiriman->logo_expedisi) }}" 
                                                                     alt="Current Logo" class="mt-2" style="max-height: 100px">
                                                            @endif
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
                                    <!-- End Modal Edit -->
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Tambah jenis_pengiriman -->
                <div class="modal fade" id="tambahjenis_pengirimanModal" tabindex="-1" aria-labelledby="tambahjenis_pengirimanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3 border border-primary">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahjenis_pengirimanModalLabel">Tambah Jenis Pengiriman</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                </button>
                            </div>
                            <form action="{{route('jenispengiriman.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_expedisi" class="form-label">Nama Ekspedisi (Opsional)</label>
                                        <input type="text" class="form-control rounded-3" id="nama_expedisi" name="nama_expedisi">
                                    </div>
                                    <div class="mb-2">
                                        <label for="jenis_kirim" class="form-label">Jenis Pengiriman</label>
                                        <select class="form-select form-control rounded-3 custom-select" name="jenis_kirim" id="jenis_kirim" required>
                                            <option value="" selected disabled>Pilih Jenis Pengiriman</option>
                                            <option value="ekonomi">Ekonomi</option>
                                            <option value="kargo">Kargo</option>
                                            <option value="reguler">Reguler</option>
                                            <option value="same day">Same Day</option>
                                            <option value="standard">Standard</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ongkos_kirim" class="form-label">Ongkos Kirim</label>
                                        <input type="number" class="form-control rounded-3" id="ongkos_kirim" name="ongkos_kirim" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="logo_expedisi" class="form-label">Logo Ekspedisi (Opsional)</label>
                                        <input type="file" class="form-control rounded-3" id="logo_expedisi" name="logo_expedisi">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Tambah jenis_pengiriman -->

                <!-- Hover table card end -->
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    <div id="styleSelector"></div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterJabatan = document.getElementById('filterJabatan');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedJabatan = filterJabatan.value.toLowerCase();

            tableRows.forEach(row => {
                const jenis_pengirimanname = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const jabatan = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                
                const matchSearch = jenis_pengirimanname.includes(searchTerm) || email.includes(searchTerm);
                const matchJabatan = selectedJabatan === '' || jabatan === selectedJabatan;

                row.style.display = matchSearch && matchJabatan ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterJabatan.addEventListener('change', filterTable);
    });
</script>

@endsection