<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h4 style="text-align: center; font-weight: lighter;" class="text-white">Temukan berbagai produk berkualitas yang kami sediakan untuk memenuhi kebutuhan Anda</h4>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-1">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-lg-3">
                                    <div class="col-xl-12">
                                        <div class="input-group w-100 mx-auto d-flex">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari obat...">
                                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                <div class="row g-2">
                                    <div class="col-3"></div>
                                    <div class="col-xl-12">
                                        <select id="filterJenis" name="jenis" class="form-select form-control rounded-3 p-3 custom-select">
                                            <option value="">Semua Jenis Obat</option>
                                            @foreach($jenis_obats as $jenis)
                                                <option value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                            <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="{{asset ('fe/img/banner-fruits.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Life <br> Care <br> You</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                    @foreach($obats as $obat)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img" style="height: 250px; overflow: hidden; border-left: 1px solid #fbbd00; border-right: 1px solid #fbbd00; border-top: 1px solid #fbbd00;">
                                                <img src="{{ asset('storage/' . $obat->foto1) }}" class="img-fluid w-100 rounded-top" alt="" style="object-fit: cover; height: 100%;">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 position-absolute text-center" 
                                            style="top: 1px; right: 0; left: 0; display: flex; justify-content: center; align-items: center; 
                                            border-radius: 10px 10px 0px 0px; border: 1px solid #fbbd00;">
                                                {{ $obat->jenis_obat->jenis }}
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="height: 180px;">
                                                <a href="{{ route('shop-detail', ['id' => $obat->id]) }}" class="text-decoration-none">
                                                    <h4 class="mb-1">{{ $obat->nama_obat }}</h4>
                                                    <p style="height: 50px; overflow: hidden;" class="text-dark">{{ Str::limit($obat->deskripsi_obat, 100) }}</p>
                                                </a>
                                                <div class="d-flex justify-content-between flex-lg-wrap mt-auto">
                                                    <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                                                    @auth('pelanggan')
                                                        <button onclick="tambahKeKeranjang(event, {{ $obat->id }})" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                                        </button>
                                                    @else
                                                        <button onclick="window.location.href='{{ route('login') }}'" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                                        </button>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <a href="#" class="rounded">&laquo;</a>
                                            <a href="#" class="active rounded">1</a>
                                            <a href="#" class="rounded">2</a>
                                            <a href="#" class="rounded">3</a>
                                            <a href="#" class="rounded">4</a>
                                            <a href="#" class="rounded">5</a>
                                            <a href="#" class="rounded">6</a>
                                            <a href="#" class="rounded">&raquo;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Fungsi untuk menambah ke keranjang
function tambahKeKeranjang(event, obatId) {
    event.preventDefault();

    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            obat_id: obatId,
            jumlah: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Produk berhasil ditambahkan ke keranjang',
                showConfirmButton: false,
                timer: 1500
            });
            updateCartCount(data.cart_count);
        } else {
            throw new Error(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang'
        });
    });
}

// Fungsi untuk update tampilan jumlah keranjang
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
        el.style.display = count > 0 ? 'inline-block' : 'none';
    });
}
</script>