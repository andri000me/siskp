<!doctype html>
<html lang="en">

<head>
    <title>Halaman Tidak Ditemukan (404) | Sistem Informasi Skripsi dan Kerja Praktek Jurusan Teknik Informatika Fakultas Teknik Universitas
        Negeri Gorontalo</title>
    <link rel="icon" type="image/svg" href="{{ asset('assets/images/siskp.svg') }}">
    <meta http-equiv="refresh" content="3600" />
    <meta name="theme-color" content="#2764af">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <style>
        @font-face {
            font-family: 'Jost';
            src: url("{{ asset('assets/fonts/Jost/static/Jost-Regular.ttf') }}");
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/siskp.css') }}">
</head>
<body>
    <div style="height: 100vh;" class="d-flex flex-wrap align-content-center">
        <div class="mx-auto text-dark text-center">
            <h1 class="display-1">404</h1>
            <p>
                Halaman atau file tidak ditemukan. <br> <br>
                Kemungkinannya adalah : <br>
                1). Anda salah menulis URL atau <br>
                2). File di server telah dihapus <br> 
                <br> <br>
                <a href="{{ url()->previous() }}" class="text-dark border-bottom"><span class="fa fa-arrow-left"></span> Kembali</a>
            </p>    
        </div>
    </div>
</body>

</html>