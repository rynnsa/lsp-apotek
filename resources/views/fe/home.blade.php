<!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">LifeCareYou - Apotek Masa Kini</h4>
                        <h1 class="mb-5 display-3 text-primary">Temukan Solusi Kesehatan Terpercaya di LifeCareYou</h1>
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Search">
                            <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;"><i class="fas fa-search" border-radius: 50px></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="{{asset ('fe/img/sertifikat1.png') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a> -->
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{asset ('fe/img/hero-img-1.png') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a> -->
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{asset ('fe/img/hero-img-2.png') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a> -->
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{asset ('fe/img/hero-img-3.png') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a> -->
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{asset ('fe/img/hero-img-4.png') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Produk LifeCareYou</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                @foreach($jenis_obats as $jenis)
                                <li class="nav-item">
                                    <a class="nav-link d-flex m-2 py-2 bg-light rounded-pill {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-{{ $jenis->id }}">
                                        <span class="text-dark" style="width: {{ strlen($jenis->jenis) > 10 ? '180px' : '100px' }}">{{ $jenis->jenis }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        @foreach ($jenis_obats as $jenis)
                        <div id="tab-{{ $jenis->id }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }} p-0">
                            <div class="container-fluid fruite py-1">
                                <div class="container py-5">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="row g-4 justify-content-center">
                                                        @foreach ($obats as $obat)
                                                            @if ($obat->id_jenis == $jenis->id)
                                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                                <div class="rounded position-relative fruite-item">
                                                                    <div class="fruite-img" style="height: 200px; overflow: hidden; border-left: 1px solid #fbbd00; border-right: 1px solid #fbbd00; border-top: 1px solid #fbbd00;">
                                                                        <img src="{{ asset('storage/' . $obat->foto1) }}" class="img-fluid w-100 rounded-top" alt="" style="object-fit: cover; height: 100%;">
                                                                    </div>
                                                                    <div class="text-white bg-secondary px-3 py-1 position-absolute text-center" 
                                                                        style="top: 1px; right: 0; left: 0; display: flex; justify-content: center; align-items: center; 
                                                                        border-radius: 10px 10px 0px 0px; border: 1px solid #fbbd00;">
                                                                        {{ $jenis->jenis }}
                                                                    </div>
                                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                                        <a href="{{ route('shop-detail', ['id' => $obat->id]) }}" class="text-decoration-none">
                                                                            <h4>{{ $obat->nama_obat }}</h4>
                                                                            <p>{{ Str::limit($obat->deskripsi_obat, 100) }}</p>
                                                                        </a>
                                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                                            <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                                                                            @auth('pelanggan')
                                                                                <button class="btn border border-secondary rounded-pill px-3 text-primary btn-tambah" data-id="{{ $obat->id }}">
                                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                                                                </button>
                                                                            @else
                                                                                <button onclick="window.location.href='{{ route('login') }}'" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Login
                                                                                </button>
                                                                            @endauth
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable py-5">
            <div class="container py-5">
                <h1 class="mb-0">Produk Terlaris</h1>
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach($obats as $obat)
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img" style="height: 200px; overflow: hidden; border-left: 1px solid #fbbd00; border-right: 1px solid #fbbd00; border-top: 1px solid #fbbd00;">
                            <img src="{{ asset('storage/' . $obat->foto1) }}" class="img-fluid w-100 rounded-top" alt="" style="object-fit: cover; height: 100%;">
                        </div>
                        <div class="p-4 rounded-bottom border border-secondary border-top-0">
                            <h4 style="height: 50px; overflow: hidden;">{{ $obat->nama_obat }}</h4>
                            <p style="height: 50px; overflow: hidden;">{{ Str::limit($obat->deskripsi_obat, 100) }}</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                                @auth('pelanggan')
                                    <button onclick="tambah({{ $obat->id }})" class="btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah
                                    </button>
                                @else
                                    <button onclick="window.location.href='{{ route('login') }}'" class="btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Login
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Sertifikat Apotek LifeCareYou</h1>
                            <p class="mb-4 text-white">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                            <!-- <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-white py-3 px-5">BUY</a> -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="{{asset ('fe/img/sertifikat1.png') }}" class="img-fluid w-100 rounded" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->


        <!-- Fact Start -->
        <div class="container-fluid py-5" >
            <div class="container ">
                <div class="bg-light p-5 rounded" style="border-radius: 100;">
                    <div class="row text-center justify-content-center position-relative">
                        <!-- Langkah 1 -->
                        <div class="col-6 col-md-3 mb-4 step-item">
                        <div class="step-circle">1</div>
                        <h5 class="mt-3">Buat Akun</h5>
                        <p>Daftarkan akun Anda untuk mulai menggunakan layanan kami</p>
                        </div>

                        <!-- Langkah 2 -->
                        <div class="col-6 col-md-3 mb-4 step-item">
                        <div class="step-circle">2</div>
                        <h5 class="mt-3">Pilih & Pesan Obat</h5>
                        <p>Temukan dan pesan obat sesuai kebutuhan Anda</p>
                        </div>

                        <!-- Langkah 3 -->
                        <div class="col-6 col-md-3 mb-4 step-item">
                        <div class="step-circle">3</div>
                        <h5 class="mt-3">Ambil Obat</h5>
                        <p>Ambil obat yang sudah dipesan di Apotek LifeCareYou</p>
                        </div>

                        <!-- Langkah 4 -->
                        <div class="col-6 col-md-3 mb-4 step-item">
                        <div class="step-circle">4</div>
                        <h5 class="mt-3">Beri Penilaian</h5>
                        <p>Bantu kami meningkatkan layanan dengan memberi ulasan</p>
                        </div>

                        <!-- Garis penghubung -->
                    <div class="step-line d-none d-md-block"></div>
                </div>
                <div class="text-center mt-4 ">
                    <a href="daftar.html" class="btn daftar-btn rounded-pill px-4 py-2 text-white shadow">Daftar Sekarang</a>
                </div>
            </div>
        </div>
        <!-- <div class="text-center mt-4">
            <a href="daftar.html" class="btn daftar-btn rounded-pill px-4 py-2 text-white">Daftar Sekarang</a>
        </div> -->
    <!-- Fact Start -->


        <!-- Tastimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Pelayanan di apotek ini sangat ramah dan cepat. Saya jadi lebih nyaman membeli obat di sini dibandingkan tempat lain.</p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-1.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Sophia Martinez</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Sistem pemesanan obatnya keren! Saya nggak perlu takut kehabisan obat karena bisa pesan dan ambil langsung di tempat.
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-2.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Ava Thompson</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Fitur pemesanan online sangat membantu! Saya bisa pesan dulu dari rumah dan tinggal ambil tanpa antre lama-lama.
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-3.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Liam Johnson</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Saya suka karena apotek ini sering kasih promo vitamin dan suplemen. Jadi bisa hemat sambil tetap jaga kesehatan.
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-4.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">James Carter</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Obat yang saya cari selalu tersedia, dan petugas apotek juga sigap memberikan penjelasan tentang aturan pakainya.
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-5.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark"> Emily Watson</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Apotek ini selalu bersih dan tertata rapi. Suasana nyaman bikin saya tenang waktu beli obat.
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{asset ('fe/img/testimonial-6.png') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Daniel William</h4>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                        <i class="fas fa-star star-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tastimonial End -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function tambah(obatId) {
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            obat_id: obatId,
            jumlah: 1
        })
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = '{{ route("login") }}';
                return;
            }
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
            // Update cart count if you have a cart counter
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

// Initialize click handlers for all add to cart buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-tambah').forEach(button => {
        button.addEventListener('click', function() {
            const obatId = this.dataset.id;
            tambah(obatId);
        });
    });
});
</script>
