<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset ('fe/css/bootstrap.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{asset ('fe/css/style.css') }}">
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
                                <h3 class="text-uppercase"><strong>Masuk LifeCareYou</strong></h3>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <form action="{{ route('authenticate') }}" method="post">
                                @csrf
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" 
                                           placeholder="Masukan Email" 
                                           id="email" 
                                           name="email" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group last mb-3">
                                    <label for="katakunci">Kata Sandi</label>
                                    <input type="password" 
                                           class="form-control @error('katakunci') is-invalid @enderror" 
                                           placeholder="Masukan Kata Sandi" 
                                           id="katakunci" 
                                           name="katakunci" 
                                           required>
                                    @error('katakunci')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <div class="d-flex justify-content-center mt-3"> 
                                    <label>Belum Punya Akun? <a href="register">Daftar</a></label>
                                </div>

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
    <script src="{{asset ('fe/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{asset ('fe/js/popper.min.js') }}"></script>
    <script src="{{asset ('fe/js/bootstrap.min.js') }}"></script>
    <script src="{{asset ('fe/js/main.copy.js') }}"></script>
</body>
</html>