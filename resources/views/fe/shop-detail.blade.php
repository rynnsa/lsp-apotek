<style>
.carousel-item img {
    height: 400px;
    object-fit: cover;
}

.thumbnail-img {
    width: 100%;
    height: 160px; /* atur sesuai kebutuhan */
    object-fit: cover;
}

.thumbnail-box {
    width: 220px;
    height: 160px;
    overflow: hidden;
}

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
    display: flex;
    flex-direction: column;
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
    flex: 1;
}
.shop-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    flex-wrap: wrap;
    margin-top: auto;
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

.mt-7 {
    margin-top: 8rem !important;
}
</style>

        <!-- Single Product Start -->
        <div class="container-fluid py-5 mt-7">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-12">
                        <div class="row g-4">
                            <div class="col-lg-5">
                                <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner border rounded" style="box-shadow: 0 6px 18px rgba(0,0,0,0.1);">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/' . $obat->foto1) }}" class="d-block w-100 img-fluid rounded" alt="Image 1">
                                        </div>
                                        @if($obat->foto2)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $obat->foto2) }}" class="d-block w-100 img-fluid rounded" alt="Image 2">
                                        </div>
                                        @endif
                                        @if($obat->foto3)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $obat->foto3) }}" class="d-block w-100 img-fluid rounded" alt="Image 3">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 ps-lg-5">
                                <h4 class="fw-bold mb-2">{{ $obat->nama_obat }}</h4>
                                <p class="mb-3">Kategori: {{ $obat->jenis_obat->jenis }}</p>
                                <h5 class="fw-bold mb-3">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</h5>
                                <div class="d-flex mb-3">
                                    <p class="{{ $obat->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $obat->stok > 0 ? 'Tersedia: '.$obat->stok.' ' : 'Stok Habis' }}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="input-group me-3" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" {{ $obat->stok <= 0 ? 'disabled' : '' }}>
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="quantity" class="form-control form-control-sm text-center border-0" 
                                               value="1" max="{{ $obat->stok }}" {{ $obat->stok <= 0 ? 'disabled' : '' }}>
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" {{ $obat->stok <= 0 ? 'disabled' : '' }}>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @auth('pelanggan')
                                        <button onclick="addToCart(event)" class="btn border border-secondary rounded-pill px-4 py-2 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                        </button>
                                    @else
                                        <button onclick="window.location.href='{{ route('login') }}'" class="btn border border-secondary rounded-pill px-4 py-2 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                        </button>
                                    @endauth
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex gap-2 justify-content-center mx-2" style="flex: 1;">
                                        <div class="border rounded thumbnail-box"
     style="cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
     data-bs-target="#productImageCarousel" data-bs-slide-to="0">

    <img src="{{ asset('storage/' . $obat->foto1) }}"
         class="thumbnail-img rounded"
         alt="Thumbnail 1">
</div>
                                        @if($obat->foto2)
                                        <div class="border rounded thumbnail-box"
     style="cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
     data-bs-target="#productImageCarousel" data-bs-slide-to="1">

    <img src="{{ asset('storage/' . $obat->foto2) }}"
         class="thumbnail-img rounded"
         alt="Thumbnail 2">
</div>
                                        @endif
                                        @if($obat->foto3)
                                        <div class="border rounded thumbnail-box"
     style="cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
     data-bs-target="#productImageCarousel" data-bs-slide-to="2">

    <img src="{{ asset('storage/' . $obat->foto3) }}"
         class="thumbnail-img rounded"
         alt="Thumbnail 3">
</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-4">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Description
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active mt-4 p-3" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p class="mb-3">{{ $obat->deskripsi_obat }}</p>
                                         <div class="px-2">
                                            <div class="row g-4">
                                                <div class="col-6">
                                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Nama Obat</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">{{$obat->nama_obat}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Harga Satuan</p>
                                                        </div>
                                                        <div class="col-6" type="number">
                                                            <p class="mb-0">{{$obat->harga_jual}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Kategori</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">{{ $obat->jenis_obat->jenis}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <form action="#">
                                <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="border-bottom rounded">
                                            <input type="text" class="form-control border-1 me-4" placeholder="Yur Name *">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="border-bottom rounded">
                                            <input type="email" class="form-control border-1" placeholder="Your Email *">
                                        </div>
                                    </div> 
                                    <div class="col-lg-12">
                                        <div class="border-bottom rounded my-4">
                                            <textarea name="" id="" class="form-control border-1" cols="30" rows="8" placeholder="Your Review *" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between py-3 mb-5">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 me-3">Please rate:</p>
                                                <div class="d-flex align-items-c enter" style="font-size: 12px;">
                                                    <i class="fa fa-star text-muted"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <a href="#" class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Post Comment</a>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}
                        
                        </div>
                    </div>
                </div>    
                <h1 class="fw-bold mb-0">Produk Sejenis Lainnya</h1>
                <div class="vesitable mt-4">
                    <div class="row g-4">
                        @forelse($related_products as $relatedObat)
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="card shop-card">
                                <div class="shop-card-img">
                                    <img src="{{ asset('storage/' . $relatedObat->foto1) }}" alt="{{ $relatedObat->nama_obat }}">
                                    <div class="shop-card-badge">{{ $relatedObat->jenis_obat->jenis }}</div>
                                </div>
                                <div class="card-body shop-card-body">
                                    <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                        <a href="{{ route('shop-detail', ['id' => $relatedObat->id]) }}" class="text-decoration-none text-dark flex-grow-1">
                                            <h4 class="shop-card-title mb-0">{{ $relatedObat->nama_obat }}</h4>
                                        </a>
                                        @guest('pelanggan')
                                            <p class="shop-price mb-0">Rp {{ number_format($relatedObat->harga_jual, 0, ',', '.') }}</p>
                                        @endguest
                                    </div>
                                    <p class="shop-card-text">{{ Str::limit($relatedObat->deskripsi_obat, 100) }}</p>
                                    @auth('pelanggan')
                                        <div class="shop-card-footer">
                                            <p class="shop-price mb-0">Rp {{ number_format($relatedObat->harga_jual, 0, ',', '.') }}</p>
                                            <button onclick="tambahKeKeranjang(event, {{ $relatedObat->id }})" class="btn btn-primary shop-add-btn text-white">
                                                <i class="fa fa-shopping-bag me-2"></i> Tambah
                                            </button>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">
                            Tidak ada produk sejenis lainnya.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Product End -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const btnMinus = document.querySelector('.btn-minus');
            const btnPlus = document.querySelector('.btn-plus');
            const maxStock = {{ $obat->stok }};

            btnMinus?.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            btnPlus?.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value < maxStock) {
                    quantityInput.value = value + 1;
                }
            });

            quantityInput?.addEventListener('change', function() {
                let value = parseInt(this.value);
                if (value < 1) {
                    this.value = 1;
                } else if (value > maxStock) {
                    this.value = maxStock;
                }
            });
        });

        function addToCart(event) {
            event.preventDefault();
            const quantity = document.getElementById('quantity').value;
            
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    obat_id: {{ $obat->id }},
                    jumlah: quantity
                })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
                return data;
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Produk berhasil ditambahkan ke keranjang',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Update cart count if you have a cart counter in the navbar
                    if (data.cart_count) {
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.cart_count;
                            el.style.display = 'inline-block';
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang'
                });
            });
        }

        // Fungsi untuk menambah ke keranjang dari produk sejenis
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
