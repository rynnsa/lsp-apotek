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
                            <h4 class="mb-0">Detail Pembelian</h4>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            Tambah +
                        </button>
                    </div>
                    <div class="card-block py-2"> 
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari No Nota...">
                                    <button class="btn" type="button" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterPembelian" class="form-select form-control rounded-3 custom-select">
                                    <option value="">Semua Obat</option>
                                    @php
                                        $addedObats = [];
                                    @endphp
                                    @foreach($obats as $obat)
                                        @if(!in_array($obat->nama_obat, $addedObats))
                                            <option value="{{ $obat->nama_obat }}">{{ $obat->nama_obat }}</option>
                                            @php
                                                $addedObats[] = $obat->nama_obat;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th> 
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Nota</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($detail_pembelians as $detail_pembelian)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{ $detail_pembelian->obat->nama_obat }}</td>                                        
                                        <td class="align-middle">{{$detail_pembelian->jumlah_beli}}</td>
                                        <td class="align-middle">{{ number_format ($detail_pembelian->harga_beli) }}</td>
                                        <td class="align-middle">{{ number_format ($detail_pembelian->subtotal) }}</td>
                                        <td class="align-middle">{{ $detail_pembelian->pembelian->no_nota }}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$detail_pembelian->id}}">
                                            </button>
                                            <form action="{{ route('detailpembelian.destroy', $detail_pembelian->id) }}" method="POST" class="d-inline delete-form" data-item-name="Detail Pembelian">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash">
                                                </button>
                                            </form>
                                        </td>
                                    </tr> 

                                    <!-- Add Edit Modal -->
                                    <div class="modal fade" id="editModal{{$detail_pembelian->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Detail Pembelian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">    
                                                    <form action="{{ route('detailpembelian.update',  $detail_pembelian->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label class="form-label">Obat</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="id_obat" required>
                                                                @php
                                                                    $addedObats = [];
                                                                @endphp
                                                                @foreach($obats as $obat)
                                                                    @if(!in_array($obat->nama_obat, $addedObats))
                                                                        <option value="{{ $obat->nama_obat }}">{{ $obat->nama_obat }}</option>
                                                                        @php
                                                                            $addedObats[] = $obat->nama_obat;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah</label>
                                                            <input type="number" class="form-control" name="jumlah_beli" value="{{ $detail_pembelian->jumlah_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Harga</label>
                                                            <input type="number" class="form-control" name="harga_beli" value="{{ $detail_pembelian->harga_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Subtotal</label>
                                                            <input type="number" class="form-control" id="subtotal_{{$detail_pembelian->id}}" value="{{ $detail_pembelian->subtotal }}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nota</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="id_pembelian" required>
                                                                @foreach($pembelians as $pembelian)
                                                                    <option value="{{ $pembelian->id }}" {{ $detail_pembelian->id_pembelian == $pembelian->id ? 'selected' : '' }}>
                                                                        {{ $pembelian->no_nota }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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

<!-- Modal Tambah pembelian -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Detail Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('detailpembelian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Obat</label>
                        <select class="form-select form-control rounded-3 custom-select" name="id_obat" required>
                            <option value="" disabled selected>Pilih obat</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah_beli" onchange="calculateSubtotal(this)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga_beli" onchange="calculateSubtotal(this)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtotal</label>
                        <input type="number" class="form-control" id="subtotal" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nota</label>
                        <select class="form-select form-control rounded-3 custom-select" name="id_pembelian" required>
                            <option value="" disabled selected>Pilih Pembelian</option>
                            @foreach($pembelians as $pembelian)
                                <option value="{{ $pembelian->id }}">{{ $pembelian->no_nota }}</option>
                            @endforeach
                        </select>
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
        const filterPembelian = document.getElementById('filterPembelian');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedObat = filterPembelian.value.toLowerCase();

            tableRows.forEach(row => {
                const noNota = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // No Nota column
                const namaObat = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Nama Obat column
                
                const matchSearch = searchTerm === '' || noNota.includes(searchTerm);
                const matchObat = selectedObat === '' || namaObat === selectedObat;

                row.style.display = (matchSearch && matchObat) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterPembelian.addEventListener('change', filterTable);
    });

    function calculateSubtotal(input) {
        const form = input.closest('form');
        const jumlah = parseFloat(form.querySelector('[name="jumlah_beli"]').value) || 0;
        const harga = parseFloat(form.querySelector('[name="harga_beli"]').value) || 0;
        const subtotal = jumlah * harga;
        const subtotalId = form.querySelector('input[id^="subtotal"]').id;
        document.getElementById(subtotalId).value = subtotal;
    }

    // Initialize subtotal calculation when inputs change
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const jumlahInput = form.querySelector('[name="jumlah_beli"]');
            const hargaInput = form.querySelector('[name="harga_beli"]');
            
            if (jumlahInput && hargaInput) {
                jumlahInput.addEventListener('input', () => calculateSubtotal(jumlahInput));
                hargaInput.addEventListener('input', () => calculateSubtotal(hargaInput));
                
                // Initial calculation
                calculateSubtotal(jumlahInput);
            }
        });
    });

    // Initialize subtotal on modal open
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) {
                const jumlahInput = form.querySelector('[name="jumlah_beli"]');
                if (jumlahInput) {
                    calculateSubtotal(jumlahInput);
                }
            }
        });
    });

    // SweetAlert2 Delete Confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const itemName = this.getAttribute('data-item-name');
                
                Swal.fire({
                    title: 'Hapus Detail Pembelian?',
                    html: `<span class="text-dark">Apakah Anda yakin ingin menghapus <strong>${itemName}</strong>?</span>`,
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