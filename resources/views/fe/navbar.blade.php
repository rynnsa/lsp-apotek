<!-- Navbar start -->
        <div class="container-fluid fixed-top ">
            <div class="container topbar bg-primary d-none d-lg-block py-3 px-6 rounded-pill shadow">
                <div class="d-flex justify-content-between ">
                    <div class="top-info ps-2">
                        <small class="me-3 "><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Jl. Harum, Bogor</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">alifecareyou@gmail.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <div class="container-fluid ms">
                        <a href="index.html" class="navbar-brand ms-3"><h1 class="text-secondary display-6">LifeCareYou</h1></a>
                        @auth
                            <span class="nav-item nav-link text-primary">Hi, {{ auth()->user()->nama_pelanggan }}</span>
                        @endauth
                        <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="fa fa-bars text-primary"></span>
                        </button>
                        <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav ms-auto">
                            <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a> 
                            <a href="shop" class="nav-item nav-link {{ Request::is('shop') ? 'active' : '' }}">Produk</a>
                            <a href="/testimonial" class="nav-item nav-link {{ Request::is('testimonial') ? 'active' : '' }}">Penilaian</a>
                            <a href="/contact" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Kontak</a>
                            <a href="/status-pemesanan" class="nav-item nav-link {{ Request::is('status-pemesanan') ? 'active' : '' }}">Pesanan</a>
                        </div>
                            <div class="d-flex m-3 me-0">
                                <a href="{{ route('cart') }}" class="position-relative me-4 my-auto">
                                    <i class="fa fa-shopping-bag fa-2x"></i>
                                    <span class="cart-count badge bg-primary" style="display: {{ auth('pelanggan')->check() && auth('pelanggan')->user()->keranjang()->count() > 0 ? 'inline-block' : 'none' }}">
                                        {{ auth('pelanggan')->check() ? auth('pelanggan')->user()->keranjang()->sum('jumlah_order') : 0 }}
                                    </span>
                                </a>
                                @auth('pelanggan')
                                    <div class="dropdown">
                                        <a href="profile-pelanggan">
                                            @if(auth('pelanggan')->user()->foto)
                                                <img src="{{ asset('storage/' . auth('pelanggan')->user()->foto) }}" alt="Profile" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #fbbd00;">
                                            @else
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                     style="width: 45px; height: 45px; border: 2px solid #fbbd00;">
                                                    <span class="text-white">{{ strtoupper(substr(auth('pelanggan')->user()->nama_pelanggan, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </a>
                                        {{-- <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href= "{{ route('profile') }}">Profile</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Logout</button>
                                                </form>
                                            </li>
                                        </ul> --}}
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="my-auto">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->