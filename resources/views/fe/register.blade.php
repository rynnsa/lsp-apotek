<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset ('fe/css/bootstrap.min.css')}}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{asset ('fe/css/style.css')}}">
</head>
<body>
    <div class="d-md-flex half">
        <div class="bg" style="background-image: url('fe/img/bg-LR.png')"></div>
        <div class="contents">
            <div class="container-fluid px-4">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-10">
                        <div class="form-block mx-auto p-4 bg-white shadow rounded" style="max-width: 1000px; min-height: 480px;">
                            <div class="text-center mb-5">
                                <h3 class="text-uppercase mb-2"><strong>Daftar LifeCareYou</strong></h3>
                                @if($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <form action="{{ route('register.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_pelanggan">Nama Lengkap</label>
                                            <input type="text" name="nama_pelanggan" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="katakunci">Kata Sandi</label>
                                            <input type="password" name="katakunci" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_telp">Nomor Telfon</label>
                                            <input type="text" name="no_telp" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Foto (opsional)</label>
                                            <input type="file" name="foto" class="form-control mb-2" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat Utama</label>
                                            <input type="text" name="alamat1" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <input type="text" name="kota1" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <input type="text" name="propinsi1" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <input type="text" name="kodepos1" class="form-control mb-2" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload KTP (opsional)</label>
                                            <input type="file" name="url_ktp" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" value="Daftar" class="btn btn-block py-2 btn-primary1">
                                <div class="d-flex justify-content-center mt-3"> 
                                    <label>Sudah Punya Akun? <a href="login">Masuk</a></label>
                                </div>
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