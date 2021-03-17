<!doctype html>
<html lang="en">

<head>
    <title>{{ ucwords(str_replace('-', ' ', Request::segment('1'))) }} - {{ env('APP_DESC') }} - {{ env('APP_JURUSAN') }}</title>
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

    <!-- Menu Navigasi Atas Umum-->
    <!-- Jika halaman detail -->
    @if(is_numeric(Request::segment('3')))
    <nav class="navbar d-none d-lg-flex navbar-expand-lg py-0 navbar-light bg-white border-bottom sticky-top">

    <!-- Jika bukan halaman detail -->
    @else
    <nav class="navbar navbar-expand-lg py-0 navbar-light bg-white border-bottom sticky-top">
    @endif
        <a class="navbar-brand text-dark" href="{{ url('masuk') }}"><img src="{{ asset('assets/images/siskp.svg') }}" class="d-inline-block align-top" width="30"> SISKP </a>

        <button class="navbar-toggler d-lg-none border-0 text-dark" type="button" data-toggle="collapse"
            data-target="#collapsibleNavId"><span class="fa fa-align-right"></span></button>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                @if(empty(Request::segment('2')) && Request::segment('1') === 'masuk')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk') }}"><span class="fa fa-home fa-fw"></span> Beranda</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk') }}"><span class="fa fa-home fa-fw"></span> Beranda</a></li>
                @endif

                @if(Request::segment('2') === 'ujian')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk/ujian') }}"><span class="far fa-edit fa-fw"></span> Ujian</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk/ujian') }}"><span class="far fa-edit fa-fw"></span> Ujian</a></li>
                @endif

                @if(Request::segment('2') === 'jadwal')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk/jadwal/'.date('Y-m')) }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk/jadwal/'.date('Y-m')) }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian</a></li>
                @endif

                @if(Request::segment('2') === 'usulan-topik')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk/usulan-topik') }}"><span class="far fa-lightbulb fa-fw"></span> Usulan Topik</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk/usulan-topik') }}"><span class="far fa-lightbulb fa-fw"></span> Usulan Topik</a></li>
                @endif

                @if(Request::segment('2') === 'kerja-praktek')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk/kerja-praktek') }}"><span class="fa fa-university fa-fw "></span> Kerja Praktek</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk/kerja-praktek') }}"><span class="fa fa-university fa-fw "></span> Kerja Praktek</a></li>
                @endif

                @if(Request::segment('2') === 'riwayat-skripsi')
                <li class="nav-item"><a class="nav-link nav-active" href="{{ url('masuk/riwayat-skripsi') }}"><span class="fa fa-history fa-fw"></span> Riwayat Skripsi</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('masuk/riwayat-skripsi') }}"><span class="fa fa-history fa-fw"></span> Riwayat Skripsi</a></li>
                @endif

                <li class="nav-item"><a class="nav-link text-dark" target="_blank" href="https://drive.google.com/drive/folders/1a_3ow0_WFAU8pT0LpInYfJKekpESsySm"><span class="fa fa-info-circle fa-fw"></span> Tentang & Panduan</a></li>

            </ul>
        </div>
    </nav>

    <!-- Menu kembali (halaman detail) -->
    @if(is_numeric(Request::segment('3')))
    <nav class="navbar d-flex d-lg-none navbar-expand-lg navbar-light bg-white border-bottom justify-content-start sticky-top text-dark">
        <a href="{{ url()->previous() }}" class="text-dark">
            <span class="fa fa-lg fa-arrow-circle-left text-primary"></span>
        </a>
        <span class="ml-2">
            Detail <span class="text-capitalize">{{ str_replace('-', ' ', Request::segment('2')) }}</span>
        </span>
    </nav>
    @endif

    <!-- Navigasi Bawah (yang ada filter) -->
    <!-- halaman riwayat skripsi -->
    @if(Request::segment('2') === 'riwayat-skripsi' || Request::segment('3') === 'cari')
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'masuk/riwayat-skripsi/cari', 'method' => 'get']) !!}
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">Judul</label>
                        {!! Form::text('judul', (!empty($judul) ? $judul : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Tahapan</label>
                        {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revisi Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Daftar Tahapan Skripsi', 'class' => 'custom-select']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>
    @endif

    <div class="container-fluid">
        <div class="row">

            <!-- Form Login -->
            @if(empty(Request::segment('2')) && Request::segment('1') === 'masuk')
            <div class="col-12 col-lg-3 my-2">
            @else
            <div class="col-12 col-lg-3 d-none d-lg-block my-2">
            @endif
                <div class="card">
                    <h6 class="card-header bg-primary text-light font-weight-bold"><span class="fa fa-sign-in-alt"></span> Masuk</h6>
                    <div class="card-body">

                        <!-- jika login gagal -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <strong><span class="fa fa-exclamation-triangle"></span> Oops!</strong>
                            @foreach($errors->all() as $error)
                            <br> {{ $error }}
                            @endforeach
                        </div>
                        @endif

                        @if(Session::has('pesan'))
                        <div class="alert alert-danger">
                            <strong><span class="fa fa-exclamation-triangle"></span> Oops!</strong>
                            <br> {{ Session::get('pesan') }}
                        </div>
                        @endif

                        @if(Session::has('info'))
                        <div class="alert alert-primary">
                            <strong><span class="fa fa-info-circle"></span> Info!</strong>
                            <br> {{ Session::get('info') }}
                        </div>
                        @endif

                        <form action="{{ url('masuk') }}" method="POST">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label>Pengguna</label>
                                {!! Form::select('pengguna', ['mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'admin' => 'Admin'], old('pengguna'), ['class' => 'custom-select', 'placeholder' => '-- Jenis Pengguna --', 'required' => 'required']) !!}
                            </div>

                            <div class="form-group">
                                <label>Username<sup>1</sup> </label>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required="required">
                                <small class="form-text text-muted">
                                    <sup>1</sup> Isi dengan NIM untuk Mahasiswa & NIP untuk Dosen
                                </small>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" value="{{ old('password') }}" class="form-control" required="required">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-sm"><span class="fa fa-sign-in-alt"></span> Masuk</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            @yield('main-masuk')

        </div>
    </div>

    <!-- Footer riwayat skripsi (yang ada filter bawah) -->
    @if(Request::segment('2') === 'riwayat-skripsi' || Request::segment('3') === 'cari')
    <nav class="nav justify-content-center border-top py-0 mb-5 mb-lg-0 bg-primary">
    @else
    <!-- Footer Umum -->
    <nav class="nav justify-content-center py-0 border-top bg-primary">
    @endif

        <a class="nav-link text-light text-center" href="https://drive.google.com/drive/folders/1a_3ow0_WFAU8pT0LpInYfJKekpESsySm" target="_blank"><span class="fa fa-info-circle" style="color:white"></span> Tentang & Panduan</a>

        <a class="nav-link text-light text-center" href="https://ft.ung.ac.id/informatika/index.html" target="_blank"><i class="far fa-copyright"></i>
            2020
            @if(date('Y') !== '2020')
                - {{ date('Y') }}
            @endif
              Teknik Informatika Universitas Negeri Gorontalo</a>

        <a class="nav-link text-light text-center" href="https://github.com/adnankasim/siskp" target="_blank">
            v.{{ env('APP_VER') }} <small>(rev:{{ env('APP_REV') }})</small>
        </a>

    </nav>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/js/jquery-3.4.1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script>

    </script>
</body>

</html>
