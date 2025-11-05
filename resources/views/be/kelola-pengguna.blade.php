<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Tim LifeCareYou</h4>
                            <span>Klik 'Tambah +' untuk menambahkan akses</span>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-primary text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                                Tambah +
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-block">

                        <!-- Add search and filter -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari pengguna...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterJabatan" class="form-select form-select form-control rounded-2 custom-select">
                                    <option value="">Semua Jabatan</option>
                                    <option value="admin">Admin</option>
                                    <option value="apoteker">Apoteker</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="karyawan">Karyawan</option>
                                    <option value="pemilik">Pemilik</option>
                                    <option value="kurir">Kurir</option>
                                </select>
                            </div>
                        </div>
                        <!-- End search and filter -->

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Jabatan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{$user->name}}</td>
                                        <td class="align-middle">{{$user->email }}</td>
                                        <td class="align-middle">
                                            <span class="password-tooltip password-dots" data-password="{{$user->password}}">
                                                ••••••••
                                            </span>
                                        </td>
                                        <td class="align-middle">{{$user->jabatan}}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-success btn-sm ti-pencil" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                                            </button>
                                            <form action="{{ route('kelola-pengguna.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-3 border border-primary">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                                        <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('kelola-pengguna.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Password</label>
                                                            <input type="password" class="form-control" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jabatan</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="jabatan">
                                                                <option value="admin" {{ $user->jabatan == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="apoteker" {{ $user->jabatan == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                                                                <option value="karyawan" {{ $user->jabatan == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                                                <option value="kasir" {{ $user->jabatan == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                                <option value="pemilik" {{ $user->jabatan == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                                                <option value="kurir" {{ $user->jabatan == 'kurir' ? 'selected' : '' }}>Kurir</option>
                                                            </select>
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
                <!-- Hover table card end -->
            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!-- Main-body end -->
    <div id="styleSelector"></div>
</div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 border border-primary">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                    <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <form action="{{route('kelola-pengguna.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control rounded-3" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control rounded-3" id="password" name="password">
                    </div>
                    <div class="mb-2">
                        <label for="role" class="form-label">Role</label>
                        <br>
                        <select class="form-select form-control rounded-3 custom-select" name="jabatan" id="jabatan">
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="admin">admin</option>
                            <option value="apoteker">apoteker</option>
                            <option value="karyawan">karyawan</option>
                            <option value="kasir">kasir</option>
                            <option value="pemilik">pemilik</option>
                            <option value="kurir">kurir</option>
                        </select>
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
<!-- End Modal Tambah User -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterJabatan = document.getElementById('filterJabatan');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedJabatan = filterJabatan.value.toLowerCase();

            tableRows.forEach(row => {
                const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const jabatan = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                
                const matchSearch = username.includes(searchTerm) || email.includes(searchTerm);
                const matchJabatan = selectedJabatan === '' || jabatan === selectedJabatan;

                row.style.display = matchSearch && matchJabatan ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterJabatan.addEventListener('change', filterTable);
    });
</script>
