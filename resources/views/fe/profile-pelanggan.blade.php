<div class="container-fluid" style="margin-top: 120px;">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar Profil -->
            <div class="col-lg-4">
                <div class="card shadow p-3">
                    <div class="text-center position-relative">
                        <div class="profile-photo ">
                            @if ($pelanggan->foto)
                                <img src="{{ asset('storage/'.$pelanggan->foto) }}" class="rounded-circle mb-3 border" width="100" height="100" style="border: 4px solid #fbbd00;">
                            @else
                                <img src="{{ asset('fe/img/testimonial-5.png') }}" class="rounded-circle mb-3" width="100" height="100">
                            @endif
                        </div>
                        <div class="position-absolute top-0 end-0 dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="fas fa-user-edit me-2"></i>Edit Profil</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left;">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-start mt-3">
                        <div class="mb-3">
                            <p class="text-muted mb-1">Nama</p>
                            <h6>{{ $pelanggan->nama_pelanggan }}</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1">Email</p>
                            <h6>{{ $pelanggan->email }}</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1">Nomor Telepon</p>
                            <h6>{{ $pelanggan->no_telp ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1">Tanggal Bergabung</p>
                            <h6>{{ $pelanggan->created_at->format('d F Y') }}</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1">KTP</p>
                            @if($pelanggan->url_ktp)
                                <img src="{{ asset('storage/'.$pelanggan->url_ktp) }}" alt="KTP" 
                                    class="img-fluid rounded" 
                                    style="max-width: 170px; height: auto;"
                                >
                            @else
                                <div class="text-center p-3 border rounded">
                                    <p class="text-muted mb-0">KTP belum diunggah</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Daftar Alamat -->
            <div class="col-lg-8">
                <div class="card shadow p-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Alamat</h5>
                    </div>
                    <!-- Alamat 1 -->
                    @if($pelanggan->alamat1)
                    <div class="bg-white p-3 rounded mb-3 border">
                        <span class="badge bg-primary mb-2">Alamat 1</span>
                        <p class="mb-0">{{ $pelanggan->alamat1 }}</p>
                        <p class="mb-0">Kota: {{ $pelanggan->kota1 }}</p>
                        <p class="mb-0">Provinsi: {{ $pelanggan->propinsi1 }}</p>
                        <p class="mb-0">Kode Pos: {{ $pelanggan->kodepos1 }}</p>
                    </div>
                    @endif

                    <!-- Alamat 2 -->
                    @if($pelanggan->alamat2)
                    <div class="bg-white p-3 rounded mb-3 border">
                        <span class="badge bg-secondary mb-2">Alamat 2</span>
                        <p class="mb-0">{{ $pelanggan->alamat2 }}</p>
                        <p class="mb-0">Kota: {{ $pelanggan->kota2 }}</p>
                        <p class="mb-0">Provinsi: {{ $pelanggan->propinsi2 }}</p>
                        <p class="mb-0">Kode Pos: {{ $pelanggan->kodepos2 }}</p>
                    </div>
                    @endif

                    <!-- Alamat 3 -->
                    @if($pelanggan->alamat3)
                    <div class="bg-white p-3 rounded mb-3 border">
                        <span class="badge bg-info mb-2">Alamat 3</span>
                        <p class="mb-0">{{ $pelanggan->alamat3 }}</p>
                        <p class="mb-0">Kota: {{ $pelanggan->kota3 }}</p>
                        <p class="mb-0">Provinsi: {{ $pelanggan->propinsi3 }}</p>
                        <p class="mb-0">Kode Pos: {{ $pelanggan->kodepos3 }}</p>
                    </div>
                    @endif

                    @if(!$pelanggan->alamat1 && !$pelanggan->alamat2 && !$pelanggan->alamat3)
                    <div class="text-center p-3">
                        <p class="text-muted mb-0">Belum ada alamat tersimpan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="profileForm">
            @csrf
            @method('POST')
            <div class="modal-header">
                <h5 class="modal-title">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $pelanggan->email }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ $pelanggan->no_telp }}" class="form-control">
                </div>
                
                <div class="alamat-container">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label>Daftar Alamat</label>
                        <button type="button" id="tambahAlamatBtn" class="btn btn-sm btn-warning text-white">
                            + Tambah Alamat
                        </button>
                    </div>
                    
                    <div id="alamatList">
                        <!-- Alamat yang sudah ada -->
                        @for($i = 1; $i <= 3; $i++)
                            @if(!empty($pelanggan->{"alamat$i"}))
                            <div class="alamat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $i == 1 ? 'primary' : ($i == 2 ? 'secondary' : 'info') }} mb-2">Alamat {{ $i }}</span>
                                    @if($i > 1)
                                    <button type="button" class="btn btn-sm btn-danger hapus-alamat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <textarea name="alamat[]" class="form-control mb-2" placeholder="Alamat lengkap">{{ $pelanggan->{"alamat$i"} }}</textarea>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="kota[]" value="{{ $pelanggan->{"kota$i"} }}" class="form-control mb-2" placeholder="Kota">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="provinsi[]" value="{{ $pelanggan->{"provinsi$i"} }}" class="form-control mb-2" placeholder="Provinsi">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="kodepos[]" value="{{ $pelanggan->{"kodepos$i"} }}" class="form-control mb-2" placeholder="Kode Pos">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endfor
                    </div>
                    <div class="mb-3">
                        <label>Foto Profil</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>KTP</label>
                        <input type="file" name="url_ktp" class="form-control">
                    </div>
                </div>
            <div class="modal-footer">
                <button class="btn btn-primary text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .dropdown-item:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }
        .dropdown-item:hover i {
            color: white !important;
        }
        .dropdown-item.text-danger:hover {
            background-color: #dc3545 !important;
        }
    </style>

</html>

<script>
document.getElementById('tambahAlamatBtn').addEventListener('click', function() {
    const alamatList = document.getElementById('alamatList');
    const alamatCount = alamatList.querySelectorAll('.alamat-item').length;
    
    if (alamatCount >= 3) {
        Swal.fire('Info', 'Maksimal 3 alamat yang dapat ditambahkan', 'info');
        return;
    }

    const newAlamat = `
        <div class="alamat-item mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-${alamatCount === 0 ? 'primary' : (alamatCount === 1 ? 'secondary' : 'info')} mb-2">Alamat ${alamatCount + 1}</span>
                <button type="button" class="btn btn-sm btn-danger hapus-alamat">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="form-group">
                <textarea name="alamat[]" class="form-control mb-2" placeholder="Alamat lengkap"></textarea>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="kota[]" class="form-control mb-2" placeholder="Kota">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="provinsi[]" class="form-control mb-2" placeholder="Provinsi">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="kodepos[]" class="form-control mb-2" placeholder="Kode Pos">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    alamatList.insertAdjacentHTML('beforeend', newAlamat);
});

// Delete address handler
document.addEventListener('click', function(e) {
    if (e.target.closest('.hapus-alamat')) {
        Swal.fire({
            title: 'Hapus Alamat',
            text: 'Yakin ingin menghapus alamat ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.closest('.alamat-item').remove();
            }
        });
    }
});

document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("profile.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message
        });
    });
});
</script>