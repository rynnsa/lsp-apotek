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
                            <h4 class="mb-0">Data Pelanggan</h4>
                            <span>Daftar pelanggan yang terdaftar di sistem</span>
                        </div>
                    </div>
                    
                    <div class="card-block">
                        <!-- Search input -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari pelanggan...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelanggans as $pelanggan)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{$pelanggan->nama_pelanggan}}</td>
                                        <td class="align-middle">{{$pelanggan->email}}</td>
                                        <td class="align-middle">{{$pelanggan->no_telp}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const telepon = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            
            const matchSearch = nama.includes(searchTerm) || 
                              email.includes(searchTerm) || 
                              telepon.includes(searchTerm);

            row.style.display = matchSearch ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
});
</script>
@endsection