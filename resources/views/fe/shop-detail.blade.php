<!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="javascript:history.back()" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center ms-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-arrow-left text-white"></i>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="d-flex m-3 me-0">
                            <a href="{{ route('cart') }}" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="cart-count badge bg-primary" style="display: {{ auth('pelanggan')->check() && auth('pelanggan')->user()->keranjang()->count() > 0 ? 'inline-block' : 'none' }}">
                                    {{ auth('pelanggan')->check() ? auth('pelanggan')->user()->keranjang()->sum('jumlah_order') : 0 }}
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Single Product Start -->
        <div class="container-fluid py-5 mt-5">
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
                                    {{-- <button class="btn btn-sm" type="button"
                                        data-bs-target="#productImageCarousel" data-bs-slide="prev"
                                        style="background-color: white; border: 2px solid #fbbd00; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-chevron-left" style="color: #fbbd00;"></i>
                                    </button> --}}
                                    <div class="d-flex gap-2 justify-content-center mx-2" style="flex: 1;">
                                        <div class="border rounded" style="width: 220px; cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" data-bs-target="#productImageCarousel" data-bs-slide-to="0">
                                            <img src="{{ asset('storage/' . $obat->foto1) }}" class="img-fluid rounded" alt="Thumbnail 1">
                                        </div>
                                        @if($obat->foto2)
                                        <div class="border rounded" style="width: 220px; cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" data-bs-target="#productImageCarousel" data-bs-slide-to="1">
                                            <img src="{{ asset('storage/' . $obat->foto2) }}" class="img-fluid rounded" alt="Thumbnail 2">
                                        </div>
                                        @endif
                                        @if($obat->foto3)
                                        <div class="border rounded" style="width: 220px; cursor: pointer; border: 2px solid #fbbd00 !important; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" data-bs-target="#productImageCarousel" data-bs-slide-to="2">
                                            <img src="{{ asset('storage/' . $obat->foto3) }}" class="img-fluid rounded" alt="Thumbnail 3">
                                        </div>
                                        @endif
                                    </div>
                                    {{-- <button class="btn btn-sm" type="button"
                                        data-bs-target="#productImageCarousel" data-bs-slide="prev"
                                        style="background-color: white; border: 2px solid #fbbd00; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-chevron-right" style="color: #fbbd00;"></i>
                                    </button> --}}
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-4">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Description
                                        </button>
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">Reviews
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
                                    <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                        <div class="d-flex">
                                            <img src="{{asset ('fe/img/avatar.jpg') }}" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>Jason Smith</h5>
                                                    <div class="d-flex mb-3">
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                    words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <img src="{{asset ('fe/img/avatar.jpg') }}" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>Sam Peters</h5>
                                                    <div class="d-flex mb-3">
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p class="text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                    words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="nav-vision" role="tabpanel">
                                        <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                                            amet diam et eos labore. 3</p>
                                        <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                            Clita erat ipsum et lorem et sit</p>
                                    </div>
                                </div>
                            </div>
                            <form action="#">
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
                            </form>
                        
                        </div>
                    </div>
                </div>    
                <h1 class="fw-bold mb-0">Related products</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i>tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-1.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-3.png') }}" class="img-fluid w-100 rounded-top bg-light" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Banana</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-4.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Bell Papper</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Potatoes</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Potatoes</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{asset ('fe/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
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
        </script>
