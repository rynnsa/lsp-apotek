<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h4 style="text-align: center; font-weight: lighter;" class="text-white">Temukan berbagai produk berkualitas yang kami sediakan untuk memenuhi kebutuhan Anda</h4>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <style>
            .shop-card {
                border: 1px solid #3b82f6;
                border-radius: 1.5rem;
                box-shadow: 0 10px 20px rgba(24, 38, 71, 0.052);
                overflow: hidden;
                transition: transform .3s ease, box-shadow .3s ease;
                background: #ffffff;
            }
            .shop-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
            }
            .shop-card-img {
                position: relative;
                height: 260px;
                overflow: hidden;
            }
            .shop-card-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .4s ease;
            }
            .shop-card:hover .shop-card-img img {
                transform: scale(1.05);
            }
            .shop-card-badge {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: rgba(52, 113, 255, 0.88);
                color: #fff;
                padding: .45rem .95rem;
                font-size: .75rem;
                letter-spacing: .05em;
                border-radius: 999px;
                text-transform: uppercase;
            }
            .shop-card-body {
                padding: 1.4rem;
            }
            .shop-card-title {
                font-size: 1.05rem;
                font-weight: 700;
                margin-bottom: .65rem;
                color: black;
            }
            .shop-card-text {
                color: #475569;
                min-height: 3rem;
                margin-bottom: 1rem;
                line-height: 1.5;
            }
            .shop-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: .75rem;
                flex-wrap: wrap;
            }
            .shop-price {
                font-weight: 700;
                color: #3b82f6;
                margin-bottom: 0;
            }
            .shop-add-btn {
                border-radius: 999px;
                padding: .65rem 1.2rem;
            }
        </style>
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
                                    {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                            <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                        </div>
                                    </div> --}}
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
                                <div id="productList" class="row g-4 justify-content-start">
                                    @forelse($obats as $obat)
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <div class="card shop-card">
                                                <div class="shop-card-img">
                                                    <img src="{{ asset('storage/' . $obat->foto1) }}" alt="{{ $obat->nama_obat }}">
                                                    <div class="shop-card-badge">{{ $obat->jenis_obat->jenis }}</div>
                                                </div>
                                                <div class="card-body shop-card-body">
                                                    <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                                        <a href="{{ route('shop-detail', ['id' => $obat->id]) }}" class="text-decoration-none text-dark flex-grow-1">
                                                            <h4 class="shop-card-title mb-0">{{ $obat->nama_obat }}</h4>
                                                        </a>
                                                        @guest('pelanggan')
                                                            <p class="shop-price mb-0">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                                                        @endguest
                                                    </div>
                                                    <p class="shop-card-text">{{ Str::limit($obat->deskripsi_obat, 100) }}</p>
                                                    @auth('pelanggan')
                                                        <div class="shop-card-footer">
                                                            <p class="shop-price mb-0">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                                                            <button onclick="tambahKeKeranjang(event, {{ $obat->id }})" class="btn btn-primary shop-add-btn">
                                                                <i class="fa fa-shopping-bag me-2"></i> Tambah
                                                            </button>
                                                        </div>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Produk tidak ditemukan.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="col-12">
                                    <div id="pagination-container" class="pagination d-flex justify-content-center mt-5">
                                        <a href="#" class="rounded">&laquo;</a>
                                        <a href="#" class="active rounded page-link" data-page="1">1</a>
                                        <a href="#" class="rounded">&raquo;</a>
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

// Fungsi untuk cari dan filter produk
function fetchShopProducts(page = 1) {
    const searchInput = document.getElementById('searchInput');
    const filterJenis = document.getElementById('filterJenis');
    const productList = document.getElementById('productList');
    const paginationContainer = document.getElementById('pagination-container');

    const params = new URLSearchParams({
        search: searchInput.value.trim(),
        jenis: filterJenis.value,
        page: page
    });

    fetch(`{{ route('search.obat') }}?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            productList.innerHTML = data.html;
            paginationContainer.innerHTML = data.pagination;
            
            // Attach event listeners ke pagination links
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageNum = this.getAttribute('data-page');
                    fetchShopProducts(pageNum);
                    window.scrollTo(0, 0);
                });
            });
        })
        .catch(error => {
            console.error('Gagal memuat produk:', error);
        });
}

const searchInput = document.getElementById('searchInput');
const filterJenis = document.getElementById('filterJenis');
let searchTimeout;

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchShopProducts(1), 300);
    });
}

if (filterJenis) {
    filterJenis.addEventListener('change', () => fetchShopProducts(1));
}

// Attach event listeners ke pagination links pada halaman pertama load
document.querySelectorAll('.page-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const pageNum = this.getAttribute('data-page');
        fetchShopProducts(pageNum);
        window.scrollTo(0, 0);
    });
});
</script>