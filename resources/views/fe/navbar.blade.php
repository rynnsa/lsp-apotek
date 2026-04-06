<!-- Navbar start -->
        <div class="container-fluid fixed-top bg-white w-full">
            <div class="container topbar bg-primary d-none d-lg-block py-3 px-6 w-full">
                <div class="d-flex justify-content-between ">
                    <div class="top-info ps-2">
                        <small class="me-3 "><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Jl. Harum, Bogor</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">alifecareyou@gmail.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2" >Instagram</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Tiktok</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">WhatsApp</small></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid bg-white w-full">
                <nav class="navbar navbar-light bg-white navbar-expand-xl w-full">
                    <div class="container-fluid">
                        @if(Request::is('shop-detail/*'))
                            <a href="javascript:history.back()" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center ms-3" style="width: 45px; height: 45px;" title="Kembali">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        @else
                            <a href="index.html" class="navbar-brand ms-3"><h1 class="text-secondary display-6">LifeCareYou</h1></a>
                        @endif
                        {{-- @auth('pelanggan')
                            <span class="nav-item nav-link text-primary">
                                Hi, {{ auth('pelanggan')->user()->nama_pelanggan }}
                            </span>
                        @endauth --}}
                        <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="fa fa-bars text-primary"></span>
                        </button>
                        <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav ms-auto">
                            <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a> 
                            <a href="shop" class="nav-item nav-link {{ Request::is('shop') ? 'active' : '' }}">Produk</a>
                            <a href="/testimonial" class="nav-item nav-link {{ Request::is('testimonial') ? 'active' : '' }}">Penilaian</a>
                            <a href="/contact" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Kontak</a>
                            @auth('pelanggan')
                            <a href="/status-pemesanan" class="nav-item nav-link {{ Request::is('status-pemesanan') ? 'active' : '' }}">Pesanan</a>
                            @endauth
                        </div>
                            <div class="d-flex m-3 me-0 align-items-center">
                                @auth('pelanggan')
                                    <!-- Keranjang -->
                                    <a href="{{ route('cart') }}" class="position-relative me-4 my-auto">
                                        <i class="fa fa-shopping-bag fa-2x"></i>
                                        <span class="cart-count badge bg-primary" 
                                            style="display: {{ auth('pelanggan')->user()->keranjang()->count() > 0 ? 'inline-block' : 'none' }}">
                                            {{ auth('pelanggan')->user()->keranjang()->sum('jumlah_order') }}
                                        </span>
                                    </a>

                                    <!-- Profile -->
                                    <div class="dropdown">
                                        <a href="profile-pelanggan">
                                            @if(auth('pelanggan')->user()->foto)
                                                <img src="{{ asset('storage/' . auth('pelanggan')->user()->foto) }}" 
                                                    class="rounded-circle" 
                                                    style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #fbbd00;">
                                            @else
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                    style="width: 45px; height: 45px; border: 2px solid #fbbd00;">
                                                    <span class="text-white">
                                                        {{ strtoupper(substr(auth('pelanggan')->user()->nama_pelanggan, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                @else
                                    <!-- Button Login -->
                                    <a href="{{ route('login') }}" class="btn btn-primary text-white rounded-pill px-4">
                                        Login
                                    </a>
                                @endauth

                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->