<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header bg-white"> 
            <div class="navbar-wrapper">
                <div class="navbar-logo bg-white">
                    <a class="mobile-menu d-flex justify-content-centere" id="mobile-collapse" href="#!" style="border-radius: 0;">
                        <i class="ti-menu-alt" style="color: blue;"></i>
                    </a>
                    <a class="mobile-search morphsearch-search" href="#">
                        <i class="ti-search"></i>
                    </a>
                    <a href="landing" class="mobile-logo d-flex justify-content-center">
                        <img class="img-fluid" src="{{ asset('be/img/LifeCareYou.png') }}" alt="Theme-Logo" style="height: 170px;" />
                    </a>
                </div>
                <div class="navbar-container container-fluid">
                    <ul class="nav-left">
                        <li>
                            <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                        </li>

                        {{-- <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li> --}}
                    </ul>
                    <ul class="nav-right">
                        <li class="header-notification" id="notificationDropdown">
                            <a href="#!" class="notification-trigger">
                                <i class="ti-bell"></i>
                                <span class="badge bg-c-pink"></span>
                            </a>
                            <ul class="show-notification" style="display: none;">
                                <li>
                                    <h6>Notifications</h6>
                                    <label class="label label-danger">New</label>
                                </li>
                                <li>
                                    <div class="media ro">
                                        <img class="d-flex align-self-center img-radius" src="{{asset ('be/img/avatar-4.jpg') }}" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">John Doe</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius rounded-circle " src="{{asset ('be/img/avatar-3.jpg') }}" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Joseph William</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius" src="{{asset ('be/img/avatar-4.jpg') }}" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Sara Soudein</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="user-profile header-notification" id="profileDropdown">
                            <a href="#!" class="profile-trigger ">
                                @if(Auth::check())
                                    <span>{{ Auth::user()->name }}</span>
                                @else
                                    <span>Guest</span>
                                @endif
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification" style="display: none;">
                                 <li class="mb-2">
                                    <div class="text-muted">Jabatan</div>
                                    <div class="fw-bold">{{ Auth::user()->jabatan }}</div>
                                </li>
                                <li class="mb-2">
                                    <div class="text-muted">Nama</div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                </li>
                                <li class="mb-3">
                                    <div class="text-muted">Email</div>
                                    <div class="fw-bold">{{ Auth::user()->email }}</div>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center border-0 w-100 bg-transparent p-0">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <div>
                            <div class="main-menu-header">
                            </div>
                        </div>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'karyawan' || Auth::user()->jabatan == 'kasir')
                            <li class="{{ Request::is('penjualan*') ? 'active' : '' }}">
                                <a href="penjualan">
                                    <span class="pcoded-micon"><i class="ti-bar-chart"></i></span>
                                    <span class="pcoded-mtext">Penjualan</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'pemilik' || Auth::user()->jabatan == 'kasir')
                            <li class="{{ Request::is('keuangan') ? 'active' : '' }}">
                                <a href="keuangan">
                                    <span class="pcoded-micon"><i class="ti-money"></i></span>
                                    <span class="pcoded-mtext">Keuangan</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'apoteker')
                            <li class="{{ Request::is('distributor*') ? 'pcoded-trigger active' : '' }}">
                                <a href="distributor">
                                    <span class="pcoded-micon"><i class="ti-package"></i></span>
                                    <span class="pcoded-mtext">Distributor</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'pemilik' || Auth::user()->jabatan == 'admin')
                            <li class="pcoded-hasmenu {{ Request::is('kelola-pengguna*') || Request::is('data-pelanggan*') ? 'pcoded-trigger active' : '' }}">
                                <a href="#">
                                    <span class="pcoded-micon"><i class="ti-user"></i></span>
                                    <span class="pcoded-mtext">Kelola Pengguna</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ Request::is('kelola-pengguna*') ? 'active' : '' }}">
                                        <a href="kelola-pengguna">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Karyawan</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('data-pelanggan*') ? 'active' : '' }}">
                                        <a href="data-pelanggan">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Pelanggan</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                         <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'apoteker' || Auth::user()->jabatan == 'admin')
                            <li class="pcoded-hasmenu {{ Request::is('daftar-obat*') || Request::is('jenis-obat*') || Request::is('obat*') ? 'pcoded-trigger active' : '' }}">
                                <a href="#">
                                    <span class="pcoded-micon"><i class="ti-agenda"></i></span>
                                    <span class="pcoded-mtext">Daftar Obat</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ Request::is('jenis-obat*') ? 'active' : '' }}">
                                        <a href="jenis-obat">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Jenis Obat</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('obat*') ? 'active' : '' }}">
                                        <a href="obat">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Obat</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'kasir' || Auth::user()->jabatan == 'apoteker')
                            <li class="pcoded-hasmenu {{ Request::is('Pembelian*') || Request::is('detail-pembelian*') || Request::is('pembelian*') ? 'pcoded-trigger active' : '' }}">
                                <a href="#">
                                    <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i></span>
                                    <span class="pcoded-mtext">Pembelian</span>
                                    <span class="pcoded-mcaret"></span>
                                </a> 
                                <ul class="pcoded-submenu">
                                    <li class="{{ Request::is('pembelian*') ? 'active' : '' }}">
                                        <a href="pembelian">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Pembelian Obat</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('detail-pembelian*') ? 'active' : '' }}">
                                        <a href="detail-pembelian">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Detail Pembelian</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'karyawan' || Auth::user()->jabatan == 'kurir')
                            <li class="pcoded-hasmenu {{ Request::is('pengiriman*') || Request::is('data-pengiriman*') || Request::is('detail-pengiriman*') ? 'pcoded-trigger active' : '' }}">
                                <a href="#">
                                    <span class="pcoded-micon"><i class="ti-truck"></i></span>
                                    <span class="pcoded-mtext">Pengiriman</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    @if(Auth::user()->jabatan == 'karyawan')
                                    <li class="{{ Request::is('jenis-pengiriman*') ? 'active' : '' }}">
                                        <a href="jenis-pengiriman">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Jenis Pengiriman</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('pengiriman*') ? 'active' : '' }}">
                                        <a href="pengiriman">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Pengaturan Pengiriman</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->jabatan == 'kurir')
                                    <li class="{{ Request::is('data-pengiriman*') ? 'active' : '' }}">
                                        <a href="data-pengiriman">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Data Pengiriman</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                            @if(Auth::user()->jabatan == 'kasir')
                            <li class="pcoded-hasmenu {{ Request::is('metode-bayar*') || Request::is('pembayaran*') ? 'pcoded-trigger active' : '' }}">
                                <a href="#">
                                    <span class="pcoded-micon"><i class="ti-credit-card"></i></span>
                                    <span class="pcoded-mtext">Pembayaran</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ Request::is('metode-bayar*') ? 'active' : '' }}">
                                        <a href="{{ route('metodebayar') }}">
                                            <span class="pcoded-micon"><i class="ti-user"></i></span>
                                            <span class="pcoded-mtext">Metode Bayar</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    

            </nav>
            </div>
