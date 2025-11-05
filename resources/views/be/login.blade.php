<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ ('fe/css/bootstrap.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ ('fe/css/style.css') }}">
</head>
<body>
    <div class="half">
        <div class="bg" style="background-image: url('fe/img/bg-LR.png')"></div>
        <div class="contents">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-12">
                        <div class="form-block mx-auto">
                            <div class="text-center mb-5">
                                <h3 class="text-uppercase"><strong>Masuk Dashmin</strong></h3>
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <form action="#" method="post">
                                @csrf
                                <div class="form-group first">
                                    <label for="username">Email</label>
                                    <input type="text" value="{{old('email')}}" class="form-control" placeholder="Masukan Email" id="username" name="email" required>
                                </div>
                                <div class="form-group last mb-3">
                                    <label for="password">Kata Sandi</label>
                                    <input type="password" value="{{old('password')}}" class="form-control" placeholder="Masukan Kata Sandi" id="password" name="password" required>
                                </div>
                                
                                <div class="d-sm-flex mb-5 align-items-center">
                                    <label class="control control--checkbox d-flex align-items-center mb-3 mb-sm-0">
                                        <input type="checkbox">
                                        <div class="control__indicator me-2"></div>
                                        <span class="mb-0">Simpan Kata Sandi</span>
                                    </label>
                                    <span class="ms-auto"><a href="#" class="forgot-pass">Lupa Kata Sandi</a></span>
                                </div>


                                <input type="submit" value="Masuk" class="btn btn-block py-2 btn-primary1">

                                {{-- <span class="text-center my-3 d-block">atau</span>
                                
                                <div>
                                    <a href="#" class="btn btn-block py-2 btn-facebook"><i class="fab fa-facebook-f mr-2"></i>Masuk dengan Facebook</a>
                                    <a href="#" class="btn btn-block py-2 btn-google"><i class="fab fa-google mr-2"></i>Masuk dengan Google</a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ ('fe/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ ('fe/js/popper.min.js') }}"></script>
    <script src="{{ ('fe/js/bootstrap.min.js') }}"></script>
    <script src="{{ ('fe/js/main.copy.js') }}"></script>
</body>
</html>