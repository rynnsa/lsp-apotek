<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{$title}}</title>
        <link rel="icon" type="image/png" href="{{ asset('fe/img/LogoLifeCareYou.png') }}">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-040frXUDx1APexFY"></script>

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@300;400;500;600;700;800;900&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{asset ('fe/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{asset ('fe/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset ('fe/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset ('fe/css/style.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            body {
                font-family: 'Poppins', sans-serif !important;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Poppins', sans-serif !important;
            }
            .display-3, .display-5 {
                font-family: 'Poppins', sans-serif !important;
            }
        </style>
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        @yield('navbar')

        @if ($title === 'Apotek LifeCareYou')
            @yield('home')
        @endif

        @if ($title === 'Kontak - LifeCareYou')
            @yield('contact')
        @endif

        @if ($title === 'Produk - LifeCareYou')
            @yield('shop')
        @endif

        @yield('shop-detail')

        @if ($title === 'Penilaian - LifeCareYou')
            @yield('testimonial')
        @endif

        @if ($title === 'Keranjang - LifeCareYou')
            @yield('cart')
        @endif

        @if ($title === 'Pemesanan - LifeCareYou')
            @yield('checkout')
        @endif

        @if ($title === 'Profile - LifeCareYou')
            @yield('profile-pelanggan')
        @endif

        @if ($title === 'Status Pemesanan - LifeCareYou')
            @yield('status-pemesanan')
        @endif


        @yield('footer')

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset ('fe/lib/easing/easing.min.js') }}"></script>
        <script src="{{asset ('fe/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{asset ('fe/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{asset ('fe/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{asset ('fe/js/main.js') }}"></script>

        @section('scripts')
        <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        </script>
        @endsection
    </body>

</html>