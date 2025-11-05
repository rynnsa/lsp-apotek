<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$title}}</title>
    <link rel="icon" type="image/png" href="{{ asset('be/img/LogoLifeCareYou.png') }}">
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}"></script>
      <![endif]-->
      <!-- Meta -->

                <meta name="csrf-token" content="{{ csrf_token() }}">


      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="CodedThemes">
      <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
      <meta name="author" content="CodedThemes">
      <!-- Favicon icon -->
      {{-- <link rel="icon" href="{{asset ('be/img/favicon.ico') }}" type="image/x-icon"> --}}
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{asset ('be/css/bootstrap/css/bootstrap.min.css') }}">
      
      <!-- Add these lines for AmCharts -->
      <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
      <script src="https://www.amcharts.com/lib/3/serial.js"></script>
      <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
      
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="{{asset ('be/icon/themify-icons/themify-icons.css') }}">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="{{asset ('be/icon/icofont/css/icofont.css') }}">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{asset ('be/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{asset ('be/css/jquery.mCustomScrollbar.css') }}">

      <!-- Menambahkan Bootstrap Icons -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  </head>

  <body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">

                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    {{-- <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <a class="mobile-search morphsearch-search" href="#">
                            <i class="ti-search"></i>
                        </a>
                        <a href="index.html">
                            <img class="img-fluid" src="{{asset ('be/img/logo.png') }}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>

                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
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
                                        <div class="media">
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
                                            <img class="d-flex align-self-center img-radius" src="{{asset ('be/img/avatar-3.jpg') }}" alt="Generic placeholder image">
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
                                <a href="#!" class="profile-trigger">
                                    <img src="{{ asset('be/img/avatar-4.jpg') }}" class="img-radius" alt="User-Profile-Image">
                                    @if(Auth::check())
                                        <span>{{ Auth::user()->name }}</span>
                                    @else
                                        <span>Guest</span>
                                    @endif
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification" style="display: none;">
                                    <li>
                                        <a href="profile" class="dropdown-item d-flex align-items-center border-0 w-100 bg-transparent p-0">
                                            <i class="ti-user"></i> Profile
                                        </a>
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
                            <div class="">
                                {{-- <div class="main-menu-header">
                                    <img class="img-40 img-radius" src="{{asset ('be/img/avatar-4.jpg') }}" alt="User-Profile-Image">
                                    <div class="user-details">
                                        @if(Auth::check())
                                        <span>{{ Auth::user()->name }}</span>
                                        @else
                                            <span>Guest</span>
                                        @endif 
                                        <span id="more-details">UX Designer<i class="ti-angle-down"></i></span>
                                    </div
                                </div> --}}

                                {{-- <div class="main-menu-content">
                                    <ul>
                                        <li class="more-details">
                                            <a href="#"><i class="ti-user"></i>View Profile</a>
                                            <a href="#!"><i class="ti-settings"></i>Settings</a>
                                            <a href="{{route('logout')}}"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pcoded-search">
                                <span class="searchbar-toggle">  </span>
                                <div class="pcoded-search-box ">
                                    <input type="text" placeholder="Search">
                                    <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                                    <a href="dashboard">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            

                                <li class="{{ Request::is('kelola-pengguna') ? 'active' : '' }}">
                                    <a href="kelola-pengguna">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                        <span class="pcoded-mtext">Kelola Pengguna</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                            

                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu {{ Request::is('daftar-obat*') || Request::is('jenis-obat*') || Request::is('obat*') ? 'pcoded-trigger active' : '' }}">
                                    <a href="#">
                                        <span class="pcoded-micon"><i class="ti-layers"></i></span>
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
                            </ul>
                            

                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu {{ Request::is('data-pelanggan*') || Request::is('pesanan*') ? 'pcoded-trigger active' : '' }}">
                                    <a href="#">
                                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                        <span class="pcoded-mtext">Pelanggan</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ Request::is('data-pelanggan*') ? 'active' : '' }}">
                                            <a href="data-pelanggan">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">Data Pelanggan</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('pesanan*') ? 'active' : '' }}">
                                            <a href="pesanan">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">Pesanan</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{{ Request::is('keuangan') ? 'active' : '' }}">
                                    <a href="keuangan">
                                        <span class="pcoded-micon"><i class="ti-money"></i><b>FC</b></span>
                                        <span class="pcoded-mtext">Keuangan</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav> --}}
                    @yield('sidebar')

                    <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page body start -->
                                    @yield('content')
                                    <!-- Page body end -->
                                </div>
                            </div>
                        </div>

                    {{-- @if ($title === 'Dashmin LifeCareYou')
                        @yield('dashboard')
                        @yield('kelola-pengguna')
                        @yield('obat')
                        @yield('jenis-obat')
                        @yield('data-pelanggan')
                        @yield('pesanan')
                        @yield('distributor')
                        @yield('pembelian')
                        @yield('detail-pembelian')
                        @yield('pembelian-create')
                        @yield('pembelian-edit')
                        @yield('metode-bayar')
                        @yield('jenis-pengiriman')
                        @yield('pengiriman')
                        @yield('penjualan')
                        @yield('data-pengiriman')
                        @yield('keuangan')
                        @yield('landing')
                    @endif --}}

<script type="text/javascript" src="{{asset ('be/js/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{asset ('be/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{asset ('be/js/popper.js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{asset ('be/js/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset ('be/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{asset ('be/js/modernizr/modernizr.js') }}"></script>
<!-- am chart -->
<script src="{{asset ('be/pages/widget/amchart/amcharts.min.js') }}"></script>
<script src="{{asset ('be/pages/widget/amchart/serial.min.js') }}"></script>
<!-- Todo js -->
<script type="text/javascript " src="{{asset ('be/pages/todo/todo.js') }}"></script>
<!-- Custom js -->
<script type="text/javascript" src="{{asset ('be/pages/dashboard/custom-dashboard.js') }}"></script>
<script type="text/javascript" src="{{asset ('be/js/script.js') }}"></script>
<script type="text/javascript " src="{{asset ('be/js/SmoothScroll.js') }}"></script>
<script src="{{asset ('be/js/pcoded.min.js') }}"></script>
<script src="{{asset ('be/js/demo-12.js') }}"></script>
<script src="{{asset ('be/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script>
var $window = $(window);
var nav = $('.fixed-button');
    $window.scroll(function(){
        if ($window.scrollTop() >= 200) {
         nav.addClass('active');
     }
     else {
         nav.removeClass('active');
     }
 });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationTrigger = document.querySelector('.notification-trigger');
    const notificationList = document.querySelector('.show-notification');
    const dropdownParent = document.getElementById('notificationDropdown');

    notificationTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        notificationList.style.display = notificationList.style.display === 'none' ? 'block' : 'none';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdownParent.contains(e.target)) {
            notificationList.style.display = 'none';
        }
    });

    // Profile dropdown functionality
    const profileTrigger = document.querySelector('.profile-trigger');
    const profileList = document.querySelector('.profile-notification');
    const profileDropdown = document.getElementById('profileDropdown');

    profileTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        profileList.style.display = profileList.style.display === 'none' ? 'block' : 'none';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileDropdown.contains(e.target)) {
            profileList.style.display = 'none';
        }
    });
});
</script>

<style>
.profile-notification a,
.profile-notification form button {
    padding: 7px 18px !important;
    text-align: left !important;
    display: block !important;
    color: #666 !important;
    font-size: 14px !important;
    cursor: pointer !important;
    outline: none !important;
    box-shadow: none !important;
    transition: none !important;
    text-decoration: none !important;
    width: 100% !important;
}

.profile-notification a:hover,
.profile-notification form button:hover,
.profile-notification a:active,
.profile-notification form button:active,
.profile-notification a:focus,
.profile-notification form button:focus {
    background: #f1f1f1 !important;
    color: #000 !important;
    outline: none !important;
    box-shadow: none !important;
}

.profile-notification a i,
.profile-notification form button i {
    margin-right: 8px !important;
    font-size: 14px !important;
}
</style>
</body>

</html>
