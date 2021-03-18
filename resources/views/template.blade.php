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
    <script src="{{ asset('assets/js/ChartJS/Chart.bundle.min.js') }}"></script>
</head>

    <!-- Menu Navigasi Atas Dashboard-->
    <nav class="navbar navbar-expand-lg py-0 navbar-light bg-white border-bottom sticky-top">
        <a class="navbar-brand text-capitalize text-dark" href="{{ url()->current() }}"><img src="{{ asset('assets/images/siskp.png') }}" class=" align-top" width="30"> {{ str_replace('-', ' ', Request::segment('1')) }}</a>

        <button class="navbar-toggler d-lg-none border-0 text-dark" type="button" data-toggle="collapse" data-target="#collapsibleNavId"><span class="fa fa-align-right"></span></button>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">

                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('profil') }}"><span class="fa fa-user-circle fa-fw"></span> {{ Session::get('nama') }}</a></li>

                <li class="nav-item"><a class="nav-link text-dark" target="_blank" href="https://drive.google.com/drive/folders/1a_3ow0_WFAU8pT0LpInYfJKekpESsySm"><span class="fa fa-info-circle fa-fw"></span> Tentang & Panduan</a></li>

                <li class="nav-item"><a class="nav-link text-dark" href="{{ url('keluar') }}"><span class="fa fa-sign-out-alt fa-fw"></span> Keluar</a></li>

            </ul>
        </div>
    </nav>
    <!-- navigasi atas / sub menu mobile -->
    <!-- sub beranda mobile -->
    @if(Request::segment(1) === 'beranda')
        @if(Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'beranda' && Request::segment(2) === 'admin') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('beranda/admin') }}">Admin</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'beranda' && Request::segment(2) === 'dosen') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('beranda/dosen') }}">Dosen</a></li>
            </ul>
        @endif
    @endif

    <!-- sub notifikasi mobile -->
    @if(Request::segment(1) === 'notifikasi')
        @if(Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'notifikasi' && Request::segment(2) === 'admin') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('notifikasi/admin') }}">Admin</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'notifikasi' && Request::segment(2) === 'dosen') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('notifikasi/dosen') }}">Saya</a></li>
            </ul>
        @endif
    @endif

    <!-- sub pendaftaran mobile -->
    @if(Request::segment(1) === 'pendaftaran' && isset($sub_menu))
        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'ujian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/ujian/semua') }}">Ujian</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'usulan-topik') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/usulan-topik/semua') }}">Usulan Topik</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'turun-kp') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/turun-kp/semua') }}">Turun KP</a></li>
            </ul>
        @elseif(Session::has('mahasiswa'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'ujian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/ujian') }}">Ujian</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'usulan-topik') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/usulan-topik') }}">Usulan Topik</a></li>
                @if(Session::has('bisa_kp'))
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'turun-kp') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pendaftaran/turun-kp') }}">Turun KP</a></li>
                @endif
            </ul>
        @endif
    @endif

    <!-- sub dosen pembimbing mobile -->
    @if(Request::segment(1) === 'dosen-pembimbing')
        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('dosen-pembimbing/skripsi/semua') }}">Skripsi</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('dosen-pembimbing/kerja-praktek/semua') }}">Kerja Praktek</a></li>
            </ul>
        @elseif(Session::has('mahasiswa'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('dosen-pembimbing/skripsi') }}">Skripsi</a></li>
                @if(Session::has('bisa_kp'))
                    <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('dosen-pembimbing/kerja-praktek') }}">Kerja Praktek</a></li>
                @endif
            </ul>
        @endif
    @endif

    <!-- sub persetujuan ujian mobile -->
    @if(Request::segment(1) === 'persetujuan-ujian')
        @if(Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'persetujuan-ujian' && Request::segment(2) === 'semua') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('persetujuan-ujian/semua') }}">Semua</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'persetujuan-ujian' && Request::segment(2) === 'mahasiswa') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('persetujuan-ujian/mahasiswa') }}">Mahasiswa</a></li>
            </ul>
        @endif
    @endif

    <!-- sub nilai ujian ujian mobile -->
    @if(Request::segment(1) === 'nilai-ujian')
        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                @if(Session::has('kajur') || Session::has('kaprodi'))
                    <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'dosen') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('nilai-ujian/dosen') }}">Mahasiswa</a></li>
                @endif
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('nilai-ujian/skripsi') }}">Skripsi</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('nilai-ujian/kerja-praktek') }}">Kerja Praktek</a></li>
            </ul>
        @endif
    @endif

    <!-- sub pengaturan mobile -->
    @if(Request::segment(1) === 'pengaturan')
        @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'umum') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pengaturan/umum') }}">Umum</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'prodi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pengaturan/prodi') }}">Prodi</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'pimpinan') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pengaturan/pimpinan') }}">Pimpinan</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'penilaian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('pengaturan/penilaian') }}">Penilaian</a></li>
            </ul>
        @endif
    @endif

    <!-- sub asistensi mobile -->
    @if(Request::segment(1) === 'asistensi')
        @if(Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'asistensi' && Request::segment(2) === 'semua') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('asistensi/semua') }}">Semua</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'asistensi' && Request::segment(2) === 'mahasiswa') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('asistensi/mahasiswa') }}">Mahasiswa</a></li>
            </ul>
        @endif
    @endif

    <!-- sub riwayat skripsi & revisi skripsi mobile -->
    @if(Request::segment(1) === 'riwayat-skripsi' || Request::segment(1) === 'revisi-skripsi')
        @if(Session::has('mahasiswa'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'riwayat-skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('riwayat-skripsi') }}">Semua</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'revisi-skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('revisi-skripsi') }}">Revisi</a></li>
            </ul>
        @endif
    @endif

    <!-- sub progres bimbingan mobile -->
    @if(Request::segment(1) === 'bimbingan')
        <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
            @if(Session::has('dosen') || Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('bimbingan/kerja-praktek') }}">KP</a></li>
            @elseif(Session::has('mahasiswa') && Session::has('bisa_kp'))
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('bimbingan/kerja-praktek') }}">KP</a></li>
            @endif
            <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'proposal') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('bimbingan/proposal') }}">Proposal</a></li>
            <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'hasil') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('bimbingan/hasil') }}">Hasil</a></li>
            <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'sidang-skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('bimbingan/sidang-skripsi') }}">Sidang Skripsi</a></li>
        </ul>
    @endif

    <!-- sub semester & periode mobile -->
    @if(Request::segment(1) === 'semester-periode')
        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-ujian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-ujian') }}">Ujian</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-usulan-topik') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-usulan-topik') }}">Usulan Topik</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-turun-kp') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-turun-kp') }}">Turun KP</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'semester') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('semester-periode/semester') }}">Semester</a></li>
            </ul>
        @endif
    @endif

    <!-- sub mahasiswa mobile -->
    @if(Request::segment(1) === 'mahasiswa')
        @if(Session::has('kajur') || Session::has('kaprodi'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && empty(Request::segment(2))) ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa') }}">Semua</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'akademik') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/akademik') }}">Akademik</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/skripsi') }}">Skripsi</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/kerja-praktek') }}">KP</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'pengujian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/pengujian') }}">Pengujian</a></li>
            </ul>
        @elseif(Session::has('dosen'))
            <ul class="nav nav-pills nav-fill d-lg-none bg-white border-bottom p-0 m-0">
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'akademik') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/akademik') }}">Akademik</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'skripsi') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/skripsi') }}">Skripsi</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/kerja-praktek') }}">Kerja Praktek</a></li>
                <li class="nav-item"><a class="nav-link mx-0 px-0 {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'pengujian') ? 'bg-primary text-white rounded-0' : 'text-dark' }}" href="{{ url('mahasiswa/pengujian') }}">Pengujian</a></li>
            </ul>
        @endif
    @endif

    <!-- Navigasi Bawah (yang ada filter) -->

    <!-- filter menu pendaftaran usulan topik-->
@if(Request::segment('1') === 'pendaftaran' && isset($filter_usulan_topik))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border mb-1 mx-1 mt-0 px-2 shadow fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'pendaftaran/usulan-topik/periode/'. $id .'/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Judul</label>
                                    {!! Form::text('usulan_judul', (!empty($usulan_judul) ? $usulan_judul : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => '-- Program Studi --', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('id_periode_daftar_usulan_topik', $id) !!}

                            <div class="form-row">
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-4">
                                    <a href="{{ url('pendaftaran/usulan-topik/periode/'. $id .'/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&usulan_judul=' . Request::get('usulan_judul') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_periode_daftar_usulan_topik=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

    <!-- filter menu pendaftaran ujian -->
@elseif(Request::segment('1') === 'pendaftaran' && isset($filter_ujian))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border mb-1 mx-1 mt-0 px-2 shadow rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'pendaftaran/ujian/periode/'. $id .'/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Ujian</label>
                                    {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], !empty($ujian) ? $ujian : null, ['class' => 'custom-select', 'placeholder' => '-- Jenis Ujian --']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => '-- Program Studi --', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('id_periode_daftar_ujian', $id) !!}

                            <div class="form-row">
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-4">
                                    <a href="{{ url('pendaftaran/ujian/periode/'. $id .'/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&ujian=' . Request::get('ujian') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_periode_daftar_ujian=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

    <!-- filter menu pendafaran turun kp -->
@elseif(Request::segment('1') === 'pendaftaran' && isset($filter_turun_kp))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'pendaftaran/turun-kp/periode/'. $id .'/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Instansi</label>
                                    {!! Form::text('instansi', (!empty($instansi) ? $instansi : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => '-- Program Studi --', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('id_periode_daftar_turun_kp', $id) !!}

                            <div class="form-row">
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-4">
                                    <a href="{{ url('pendaftaran/turun-kp/periode/'. $id .'/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&instansi=' . Request::get('instansi') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_periode_daftar_turun_kp=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu dosen -->
@elseif(Request::segment('1') === 'dosen' && isset($filter_dosen))

    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'dosen/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">NIP</label>
                                    {!! Form::text('nip', (!empty($nip) ? $nip : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($prodi) ? $prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Status</label>
                                    {!! Form::select('status', ['aktif' => 'Aktif', 'tidak-aktif' => 'Tidak Aktif', 'cuti' => 'Cuti'], (!empty($status) ? $status : null), ['placeholder' => 'Daftar Status', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Bisa Menguji</label>
                                    {!! Form::select('bisa_menguji', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($bisa_menguji) ? $bisa_menguji : null), ['placeholder' => 'Bisa Menguji ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Bisa Membimbing</label>
                                    {!! Form::select('bisa_membimbing', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($bisa_membimbing) ? $bisa_membimbing : null), ['placeholder' => 'Bisa Membimbing ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-4">
                                    <a href="{{ url('dosen/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nip=' . Request::get('nip') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&status=' . Request::get('status') .
                                     '&bisa_menguji=' . Request::get('bisa_menguji') .
                                     '&bisa_membimbing=' . Request::get('bisa_membimbing')) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu mahasiswa -->
@elseif(Request::segment('1') === 'mahasiswa' && isset($filter_mahasiswa))

    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'mahasiswa/cari', 'method' => 'get']) !!}

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
                                    <label for="">Tahapan Skripsi</label>
                                    {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revis Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Tahapan Skripsi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Tahapan KP</label>
                                    {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran Ujian',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan Kerja Praktek', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Dosen PA</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, (!empty($id_dosen) ? $id_dosen : null), ['placeholder' => 'Daftar Dosen PA', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            @if(!Session::has('kaprodi'))
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-6">
                                    <label for="">Kontrak KP</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak Kerja Praktek ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-7">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-5">
                                    <a href="{{ url('mahasiswa/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_kp=' . Request::get('tahapan_kp') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_dosen=' . Request::get('id_dosen') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_kp=' . Request::get('kontrak_kp') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu mahasiswa pendampingan akademik -->
@elseif(Request::segment('2') === 'akademik' && isset($filter_bimbingan_akademik))

    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'mahasiswa/akademik/cari', 'method' => 'get']) !!}

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
                                    <label for="">Tahapan Skripsi</label>
                                    {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revis Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Tahapan Skripsi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Tahapan KP</label>
                                    {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran Ujian',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan Kerja Praktek', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-6">
                                    <label for="">Kontrak KP</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak Kerja Praktek ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-7">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-5">
                                    <a href="{{ url('mahasiswa/akademik/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_kp=' . Request::get('tahapan_kp') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_kp=' . Request::get('kontrak_kp') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu mahasiswa bimbingan skripsi -->
@elseif(Request::segment('2') === 'skripsi' && isset($filter_bimbingan_skripsi))

    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'mahasiswa/skripsi/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Tahapan Skripsi</label>
                                    {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revis Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Tahapan Skripsi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="rorm row">
                                <div class="form-group col-6">
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Pembimbing</label>
                                    {!! Form::select('pembimbing', ['utama' => 'Utama', 'pendamping' => 'Pendamping'], (!empty($pembimbing) ? $pembimbing : 'utama'), ['placeholder' => 'Pembimbing ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Semester</label>
                                    {!! Form::select('id_semester', $daftar_semester, (!empty($id_semester) ? $id_semester : null), ['placeholder' => 'Daftar Semester', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-7">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-5">
                                    <a href="{{ url('mahasiswa/skripsi/export?' .
                                     'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi') .
                                     '&pembimbing=' . Request::get('pembimbing') .
                                     '&id_semester=' . Request::get('id_semester')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu mahasiswa bimbingan kerja praktek -->
@elseif(Request::segment('2') === 'kerja-praktek' && isset($filter_bimbingan_kp))

    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white mb-1 mx-1 mt-0 px-2 text-nowrap shadow border rounded fixed-bottom justify-content-between">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm"></span> <small>Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'mahasiswa/kerja-praktek/cari', 'method' => 'get']) !!}

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Tahapan KP</label>
                                    {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan KP', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="rorm row">
                                <div class="form-group col-6">
                                    <label for="">Kontrak KP</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak KP ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Pembimbing</label>
                                    {!! Form::select('pembimbing', ['utama' => 'Utama', 'pendamping' => 'Pendamping'], (!empty($pembimbing) ? $pembimbing : 'utama'), ['placeholder' => 'Pembimbing ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Semester</label>
                                    {!! Form::select('id_semester', $daftar_semester, (!empty($id_semester) ? $id_semester : null), ['placeholder' => 'Daftar Semester', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-7">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-5">
                                    <a href="{{ url('mahasiswa/kerja-praktek/export?' .
                                     'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_kp=' . Request::get('tahapan_kp') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_kp=' . Request::get('kontrak_kp') .
                                     '&pembimbing=' . Request::get('pembimbing') .
                                     '&id_semester=' . Request::get('id_semester')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu riwayat skripsi -->
@elseif(Request::segment('1') === 'riwayat-skripsi' && isset($filter_riwayat))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'riwayat-skripsi/cari', 'method' => 'get']) !!}
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
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('riwayat-skripsi/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&judul=' . Request::get('judul') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi')
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .xls </a>
                                </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu dosen pembimbing skripsi -->
@elseif(Request::segment('2') === 'skripsi' && isset($filter_dosbing_skripsi))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'dosen-pembimbing/skripsi/semester/'. $id .'/cari', 'method' => 'get']) !!}
                {!! Form::hidden('id_semester', $id) !!}
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
                        <label for="">Tahapan Skripsi</label>
                        {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revis Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Tahapan Skripsi', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Pembimbing 1</label>
                        {!! Form::select('dosbing_satu_skripsi', $daftar_dosen, (!empty($dosbing_satu_skripsi) ? $dosbing_satu_skripsi : null), ['placeholder' => 'Pembimbing Utama', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Pembimbing 2</label>
                        {!! Form::select('dosbing_dua_skripsi', $daftar_dosen, (!empty($dosbing_dua_skripsi) ? $dosbing_dua_skripsi : null), ['placeholder' => 'Pembimbing Pendamping', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('dosen-pembimbing/skripsi/semester/'. $id .'/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&dosbing_satu_skripsi=' . Request::get('dosbing_satu_skripsi') .
                                     '&dosbing_dua_skripsi=' . Request::get('dosbing_dua_skripsi') .
                                     '&id_semester=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .xls </a>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu dosen pembimbing skripsi -->
@elseif(Request::segment('2') === 'skripsi' && isset($filter_dosbing_kosong))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'dosen-pembimbing/skripsi/semester/tidak-diketahui/cari', 'method' => 'get']) !!}
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Pembimbing 1</label>
                        {!! Form::select('dosbing_satu_skripsi', $daftar_dosen, (!empty($dosbing_satu_skripsi) ? $dosbing_satu_skripsi : null), ['placeholder' => 'Pembimbing Utama', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Pembimbing 2</label>
                        {!! Form::select('dosbing_dua_skripsi', $daftar_dosen, (!empty($dosbing_dua_skripsi) ? $dosbing_dua_skripsi : null), ['placeholder' => 'Pembimbing Pendamping', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('dosen-pembimbing/skripsi/semester/tidak-diketahui/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&dosbing_satu_skripsi=' . Request::get('dosbing_satu_skripsi') .
                                     '&dosbing_dua_skripsi=' . Request::get('dosbing_dua_skripsi')
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .xls </a>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu dosen pembimbing kerja praktek -->
@elseif(Request::segment('2') === 'kerja-praktek' && isset($filter_dosbing_kp))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/semester/'. $id .'/cari', 'method' => 'get']) !!}
                {!! Form::hidden('id_semester', $id) !!}
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Lokasi</label>
                        {!! Form::text('lokasi', (!empty($lokasi) ? $lokasi : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">Tahapan Kerja Praktek</label>
                        {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran Ujian',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan Kerja Praktek', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Pembimbing 1</label>
                        {!! Form::select('dosbing_satu_kp', $daftar_dosen, (!empty($dosbing_satu_kp) ? $dosbing_satu_kp : null), ['placeholder' => 'Pembimbing Utama', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Pembimbing 2</label>
                        {!! Form::select('dosbing_dua_kp', $daftar_dosen, (!empty($dosbing_dua_kp) ? $dosbing_dua_kp : null), ['placeholder' => 'Pembimbing Pendamping', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('dosen-pembimbing/kerja-praktek/semester/'. $id .'/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&lokasi=' . Request::get('lokasi') .
                                     '&dosbing_satu_kp=' . Request::get('dosbing_satu_kp') .
                                     '&dosbing_dua_kp=' . Request::get('dosbing_dua_kp') .
                                     '&id_semester=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .xls </a>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu ujian skripsi -->
@elseif(Request::segment('1') === 'nilai-ujian' && isset($filter_ujian_skripsi))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'nilai-ujian/skripsi/cari', 'method' => 'get']) !!}
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Program Studi</label>
                        {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Program Studi', 'class' => 'custom-select']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('nilai-ujian/skripsi/export?' .
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_prodi=' . Request::get('id_prodi')
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .xls </a>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>

<!-- filter menu ujian kerja praktek -->
@elseif(Request::segment('1') === 'nilai-ujian' && isset($filter_ujian_kp))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'nilai-ujian/kerja-praktek/cari', 'method' => 'get']) !!}
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
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

<!-- filter menu jadwal ujian -->
@elseif(Request::segment('1') === 'jadwal-ujian' && isset($filter_jadwal_ujian))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white border shadow fixed-bottom rounded justify-content-between mb-1 mx-1 mt-0 px-2">

        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>

        <a class="text-dark" href="{{ url('masuk') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>

        <button class="navbar-toggler d-lg-none border-0 text-dark small" type="button" data-toggle="collapse" data-target="#filterBottom"><span class="fa fa-search fa-sm small"></span> <small style="font-size: .8rem;">Cari</small> </button>

        <div class="collapse navbar-collapse pb-2" id="filterBottom">
            {!! Form::open(['url' => 'jadwal-ujian/'.$tahun.'-'.$bulan.'/cari', 'method' => 'get']) !!}
                {!! Form::hidden('bulan', $bulan) !!}
                {!! Form::hidden('tahun', $tahun) !!}
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">Nama</label>
                        {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">NIM</label>
                        {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Angkatan</label>
                        {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Program Studi</label>
                        {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Program Studi', 'class' => 'custom-select']) !!}
                    </div>
                    <div class="form-group col-6">
                        <label for="">Ujian</label>
                        {!! Form::select('ujian', ['kerja-praktek' => 'Seminar Kerja Praktek', 'proposal' => 'Seminar Proposal', 'hasil' => 'Seminar Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], (!empty($ujian) ? $ujian : null), ['placeholder' => 'Jenis Ujian', 'class' => 'custom-select']) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-7">
                        <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span>
                            Cari</button>
                    </div>
                    <div class="col-5">
                                    <a href="{{ url('jadwal-ujian/'. $tahun . '-' . $bulan .'/export')  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                </div>

            {!! Form::close() !!}
        </div>

    </nav>


    <!-- menu bottom default halaman detail -->
@elseif(isset($bottom_detail))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white rounded fixed-bottom justify-content-between border mb-1 mx-1 mt-0 px-2 shadow">
        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>
    </nav>

    <!-- menu bottom detail asistensi -->
@elseif(isset($bottom_asistensi))
    <nav class="navbar navbar-expand-lg navbar-light d-lg-none bg-white rounded fixed-bottom justify-content-between border mb-1 mx-1 mt-0 px-2 shadow">
        <a class="text-dark" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
        <a class="text-dark" href="{{ url('/') }}"><span class="fa fa-home"></span> <span class="">Beranda</span></a>
        @if(Session::has('mahasiswa') || Session::has('dosen'))
        <a class="text-dark" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><span class="fa fa-comments"></span> <span class="">Komentar</span></a>
        @endif
    </nav>

@else
    <!-- Navigasi Bawah Dashboard -->
    <nav class="navbar navbar-expand-lg nav nav-pills nav-justified navbar-light d-lg-none bg-white border fixed-bottom mb-1 mx-1 mt-0 px-0 py-0 text-nowrap shadow rounded" >

        <!-- beranda bawah -->
        @if(Session::has('admin'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'beranda') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('beranda/admin') }}"><span class="fa fa-home"></span> <br> <small style="font-size: .7rem;">Beranda</small></a>
        @elseif(Session::has('dosen'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'beranda') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('beranda/dosen') }}"><span class="fa fa-home"></span> <br> <small style="font-size: .7rem;">Beranda</small></a>
        @elseif(Session::has('mahasiswa'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'beranda') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('beranda/mahasiswa') }}"><span class="fa fa-home"></span> <br> <small style="font-size: .7rem;">Beranda</small></a>
        @endif

        <!-- notifikasi bawah -->
        @if(Session::has('admin'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'notifikasi') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('notifikasi/admin') }}">
        @elseif(Session::has('dosen'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'notifikasi') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('notifikasi/dosen') }}">
        @elseif(Session::has('mahasiswa'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'notifikasi') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('notifikasi/mahasiswa') }}">
        @endif
        <span class="far fa-bell"></span>
        @if($notifikasi->count())
            <span class="badge badge-danger badge-notif">{{ $notifikasi->count() }}</span>
        @endif
        <br> <small style="font-size: .7rem;"> Notifikasi</small> </a>

        <!--
            pendaftaran bawah (admin & mahasiswa)
            nilai ujian bawah (dosen)
        -->
        @if(Session::has('mahasiswa') || Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
            @if(Session::has('mahasiswa'))
                <a class="nav-bottom text-center {{ (Request::segment(1) === 'pendaftaran') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('pendaftaran/ujian') }}"><span class="far fa-edit"></span> <br> <small style="font-size: .7rem;">Pendaftaran</small></a>
            @elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <a class="nav-bottom text-center {{ (Request::segment(1) === 'pendaftaran') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('pendaftaran/ujian/semua') }}"><span class="far fa-edit"></span> <br> <small style="font-size: .7rem;">Pendaftaran</small></a>
            @endif
        @else
                <a class="nav-bottom text-center {{ (Request::segment(1) === 'nilai-ujian') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('nilai-ujian/dosen') }}"><span class="fa fa-check-double"></span> <br> <small style="font-size: .7rem;">Nilai Ujian</small></a>
        @endif

        <!--
            asistensi bawah (dosen & mahasiswa)
            periode bawah (admin)
        -->
        @if(Session::has('mahasiswa'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'asistensi') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('asistensi') }}"><span class="far fa-comments"></span> <br> <small style="font-size: .7rem;">Asistensi</small></a>
        @elseif(Session::has('dosen'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'asistensi') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('asistensi/mahasiswa') }}"><span class="far fa-comments"></span> <br> <small style="font-size: .7rem;">Asistensi</small></a>
        @elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
            <a class="nav-bottom text-center {{ (Request::segment(1) === 'semester-periode') ? 'nav-bottom-active' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-ujian') }}"><span class="far fa-calendar-alt"></span> <br> <small style="font-size: .7rem;">Periode</small></a>
        @endif

        <button class="navbar-toggler d-lg-none border-0 text-dark" type="button" data-toggle="collapse"
            data-target="#navbarLainnya"><span class="fa fa-bars"></span> <br> <small
                style="font-size: .7rem;">Lainnya</small> </button>

        <div class="collapse navbar-collapse" id="navbarLainnya">
            <ul class="list-group border-0 list-group-flush">

                <!-- dosen pembimbing bawah -->
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'dosen-pembimbing') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('dosen-pembimbing/skripsi/semua') }}" class="{{ (Request::segment(1) === 'dosen-pembimbing') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-friends fa-fw"></span> Pembimbing </a></li>
                @elseif(Session::has('mahasiswa'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'dosen-pembimbing') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('dosen-pembimbing/skripsi') }}" class="{{ (Request::segment(1) === 'dosen-pembimbing') ? 'text-white' : 'text-dark' }}"><span class="far fa-calendar-alt fa-fw"></span> Pembimbing </a></li>
                @endif

                <!-- persetujuan ujian bawah -->
                @if(Session::has('admin'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian/semua') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian </a></li>
                @elseif(Session::has('dosen'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian/mahasiswa') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian </a></li>
                @elseif(Session::has('mahasiswa'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian </a></li>
                @endif

                <!-- asistensi bawah (admin) -->
                @if(Session::has('admin'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'asistensi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('asistensi/semua') }}" class="{{ (Request::segment(1) === 'asistensi') ? 'text-white' : 'text-dark' }}"><span class="far fa-comments fa-fw"></span> Asistensi </a></li>
                @endif

                <!-- nilai ujian bawah (admin & mahasiswa) -->
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'nilai-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('nilai-ujian/skripsi') }}" class="{{ (Request::segment(1) === 'nilai-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-check-double fa-fw"></span> Nilai Ujian </a></li>
                @elseif(Session::has('mahasiswa'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'nilai-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('nilai-ujian/mahasiswa') }}" class="{{ (Request::segment(1) === 'nilai-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-check-double fa-fw"></span> Nilai Ujian </a></li>
                @endif

                <!-- progres bimbingan bawah -->
                <li class="list-group-item py-2 {{ (Request::segment(1) === 'bimbingan') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('bimbingan/hasil') }}" class="{{ (Request::segment(1) === 'bimbingan') ? 'text-white' : 'text-dark' }}"><span class="fa fa-tasks fa-fw"></span> Progres Bimbingan </a></li>

                <!-- peserta ujian bawah -->
                @if(Session::has('mahasiswa'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'peserta-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('peserta-ujian') }}" class="{{ (Request::segment(1) === 'peserta-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-street-view fa-fw"></span> Peserta Ujian </a></li>
                @elseif(Session::has('dosen') && Session::has('kajur') || Session::has('dosen') && Session::has('kaprodi') || Session::has('admin'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'peserta-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('peserta-ujian') }}" class="{{ (Request::segment(1) === 'peserta-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-street-view fa-fw"></span> Peserta Ujian </a></li>
                @endif

                <!-- jadwal ujian bawah -->
                @if(Session::has('mahasiswa'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                @elseif(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian/semua') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                @elseif(Session::has('dosen'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian/dosen') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                @endif

                <!-- riwayat skripsi bawah -->
                <li class="list-group-item py-2 {{ (Request::segment(1) === 'riwayat-skripsi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('riwayat-skripsi') }}" class="{{ (Request::segment(1) === 'riwayat-skripsi') ? 'text-white' : 'text-dark' }}"><span class="fa fa-history fa-fw"></span> Riwayat Skripsi </a></li>

                <!-- mahasiswa bawah -->
                @if(Session::has('admin'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'mahasiswa') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('mahasiswa') }}" class="{{ (Request::segment(1) === 'mahasiswa') ? 'text-white' : 'text-dark' }}"><span class="fa fa-users fa-fw"></span> Mahasiswa </a></li>
                @elseif(Session::has('dosen'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'mahasiswa') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('mahasiswa/skripsi') }}" class="{{ (Request::segment(1) === 'mahasiswa') ? 'text-white' : 'text-dark' }}"><span class="fa fa-users fa-fw"></span> Mahasiswa </a></li>
                @endif

                <!-- semester & periode bawah (kajur & kaprodi) -->
                @if(Session::has('dosen') && Session::has('kajur') || Session::has('dosen') && Session::has('kaprodi'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'semester-periode') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('semester-periode/periode-daftar-ujian') }}" class="{{ (Request::segment(1) === 'semester-periode') ? 'text-white' : 'text-dark' }}"><span class="far fa-calendar-alt fa-fw"></span> Semester & Periode </a></li>
                @endif

                <!-- dosen, admin, pengaturan bawah (admin) -->
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'dosen') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('dosen') }}" class="{{ (Request::segment(1) === 'dosen') ? 'text-white' : 'text-dark' }}"><span class="fa fa-chalkboard-teacher fa-fw"></span> Dosen </a></li>

                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'admin') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('admin') }}" class="{{ (Request::segment(1) === 'admin') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-secret fa-fw"></span> Admin </a></li>

                    <li class="list-group-item py-2 {{ (Request::segment(1) === 'pengaturan') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('pengaturan/umum') }}" class="{{ (Request::segment(1) === 'pengaturan') ? 'text-white' : 'text-dark' }}"><span class="fa fa-cogs fa-fw"></span> Pengaturan </a></li>
                @endif
            </ul>
        </div>

    </nav>
@endif
    <div class="container-fluid">
        <div class="row">

            <!-- Navigasi Samping Dashboard -->
            <div class="col-12 d-none d-lg-block col-lg-3 my-2">

                <div class="card">
                    <ul class="list-group border-0 list-group-flush">

                        <!-- beranda samping -->
                        @if(Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'beranda') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('beranda/admin') }}" class="{{ (Request::segment(1) === 'beranda') ? 'text-white' : 'text-dark' }}"><span class="fa fa-home fa-fw"></span> Beranda </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'beranda') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'beranda') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-home fa-fw"></span> Beranda
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'beranda' && Request::segment(2) === 'admin') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('beranda/admin') }}">Admin</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'beranda' && Request::segment(2) === 'dosen') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('beranda/dosen') }}" href="{{ url('beranda/dosen') }}">Dosen</a>
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'beranda') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('beranda/dosen') }}" class="{{ (Request::segment(1) === 'beranda') ? 'text-white' : 'text-dark' }}"><span class="fa fa-home fa-fw"></span> Beranda </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'beranda') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('beranda/mahasiswa') }}" class="{{ (Request::segment(1) === 'beranda') ? 'text-white' : 'text-dark' }}"><span class="fa fa-home fa-fw"></span> Beranda </a></li>
                        @endif

                        <!-- notifikasi samping -->
                        @if(Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'notifikasi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('notifikasi/admin') }}" class="{{ (Request::segment(1) === 'notifikasi') ? 'text-white' : 'text-dark' }}"><span class="far fa-bell fa-fw"></span> Notifikasi
                            @if($notifikasi->count())
                                <span class="badge badge-danger">{{ $notifikasi->count() }}</span>
                            @endif
                            </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'notifikasi') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'notifikasi') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="far fa-bell fa-fw"></span> Notifikasi
                                    @if($notifikasi->count())
                                        <span class="badge badge-danger">{{ $notifikasi->count() }}</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'notifikasi' && Request::segment(2) === 'admin') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('notifikasi/admin') }}">Admin</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'notifikasi' && Request::segment(2) === 'dosen') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('notifikasi/dosen') }}">Saya</a>
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'notifikasi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('notifikasi/dosen') }}" class="{{ (Request::segment(1) === 'notifikasi') ? 'text-white' : 'text-dark' }}"><span class="far fa-bell fa-fw"></span> Notifikasi
                            @if($notifikasi->count())
                                <span class="badge badge-danger">{{ $notifikasi->count() }}</span>
                            @endif
                            </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'notifikasi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('notifikasi/mahasiswa') }}" class="{{ (Request::segment(1) === 'notifikasi') ? 'text-white' : 'text-dark' }}"><span class="far fa-bell fa-fw"></span> Notifikasi
                            @if($notifikasi->count())
                                <span class="badge badge-danger">{{ $notifikasi->count() }}</span>
                            @endif
                            </a></li>
                        @endif

                        <!-- pendaftaran samping -->
                        @if(Session::has('mahasiswa') || Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'pendaftaran') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'pendaftaran') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="far fa-edit fa-fw"></span> Pendaftaran
                                </a>
                                <div class="dropdown-menu">
                                    @if(Session::has('mahasiswa'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'ujian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/ujian') }}">Ujian</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'usulan-topik') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/usulan-topik') }}">Usulan Topik</a>
                                        @if(Session::has('bisa_kp'))
                                            <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'turun-kp') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/turun-kp') }}">Turun Kerja Praktek</a>
                                        @endif
                                    @elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'ujian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/ujian/semua') }}">Ujian</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'usulan-topik') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/usulan-topik/semua') }}">Usulan Topik</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pendaftaran' && Request::segment(2) === 'turun-kp') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pendaftaran/turun-kp/semua') }}">Turun Kerja Praktek</a>
                                    @endif
                            </li>
                        @endif

                        <!-- dosen pembimbing samping -->
                        @if(Session::has('mahasiswa') || Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'dosen-pembimbing') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'dosen-pembimbing') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-user-friends fa-fw"></span> Pembimbing
                                </a>
                                <div class="dropdown-menu">
                                    @if(Session::has('mahasiswa'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('dosen-pembimbing/skripsi') }}">Skripsi</a>
                                        @if(Session::has('bisa_kp'))
                                            <a class="dropdown-item {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('dosen-pembimbing/kerja-praktek') }}">Kerja Praktek</a>
                                        @endif
                                    @elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('dosen-pembimbing/skripsi/semua') }}">Skripsi</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'dosen-pembimbing' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('dosen-pembimbing/kerja-praktek/semua') }}">Kerja Praktek</a>
                                    @endif
                            </li>
                        @endif

                        <!-- persetujuan ujian samping -->
                        @if(Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian/semua') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian
                            </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'persetujuan-ujian' && Request::segment(2) === 'semua') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('persetujuan-ujian/semua') }}">Semua</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'persetujuan-ujian' && Request::segment(2) === 'mahasiswa') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('persetujuan-ujian/mahasiswa') }}">Mahasiswa</a>
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian/mahasiswa') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian
                            </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'persetujuan-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('persetujuan-ujian') }}" class="{{ (Request::segment(1) === 'persetujuan-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-check fa-fw"></span> Persetujuan Ujian
                            </a></li>
                        @endif

                        <!-- asistensi samping -->
                        @if(Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'asistensi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('asistensi/semua') }}" class="{{ (Request::segment(1) === 'asistensi') ? 'text-white' : 'text-dark' }}"><span class="far fa-comments fa-fw"></span> Asistensi
                            </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'asistensi') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'asistensi') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="far fa-comments fa-fw"></span> Asistensi
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'asistensi' && Request::segment(2) === 'semua') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('asistensi/semua') }}">Semua</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'asistensi' && Request::segment(2) === 'mahasiswa') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('asistensi/mahasiswa') }}">Mahasiswa</a>
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'asistensi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('asistensi/mahasiswa') }}" class="{{ (Request::segment(1) === 'asistensi') ? 'text-white' : 'text-dark' }}"><span class="far fa-comments fa-fw"></span> Asistensi
                            </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'asistensi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('asistensi') }}" class="{{ (Request::segment(1) === 'asistensi') ? 'text-white' : 'text-dark' }}"><span class="far fa-comments fa-fw"></span> Asistensi
                            </a></li>
                        @endif

                        <!-- progres bimbingan samping -->
                        <li class="list-group-item {{ (Request::segment(1) === 'bimbingan') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'bimbingan') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-tasks fa-fw"></span> Progres Bimbingan
                                </a>
                                <div class="dropdown-menu">
                                    @if(Session::has('dosen') || Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('bimbingan/kerja-praktek') }}">Kerja Praktek</a>
                                    @elseif(Session::has('mahasiswa') && Session::has('bisa_kp'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('bimbingan/kerja-praktek') }}">Kerja Praktek</a>
                                    @endif
                                    <a class="dropdown-item {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'proposal') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('bimbingan/proposal') }}">Proposal</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'hasil') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('bimbingan/hasil') }}">Hasil</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'bimbingan' && Request::segment(2) === 'sidang-skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('bimbingan/sidang-skripsi') }}">Sidang Skripsi</a>
                                </li>

                        <!-- peserta ujian samping -->
                        @if(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'peserta-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('peserta-ujian') }}" class="{{ (Request::segment(1) === 'peserta-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-street-view fa-fw"></span> Peserta Ujian </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'peserta-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('peserta-ujian') }}" class="{{ (Request::segment(1) === 'peserta-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-street-view fa-fw"></span> Peserta Ujian </a></li>
                        @endif

                        <!-- jadwal ujian samping -->
                        @if(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian/semua') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'jadwal-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('jadwal-ujian/dosen') }}" class="{{ (Request::segment(1) === 'jadwal-ujian') ? 'text-white' : 'text-dark' }}"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a></li>
                        @endif

                        <!-- nilai ujian samping -->
                        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'nilai-ujian') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'nilai-ujian') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-check-double fa-fw"></span> Nilai Ujian
                                </a>
                                <div class="dropdown-menu">
                                    @if(Session::has('admin'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('nilai-ujian/skripsi') }}">Skripsi</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('nilai-ujian/kerja-praktek') }}">Kerja Praktek</a>
                                    @elseif(Session::has('kajur') || Session::has('kaprodi'))
                                        <a class="dropdown-item {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('nilai-ujian/skripsi') }}">Skripsi</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('nilai-ujian/kerja-praktek') }}">Kerja Praktek</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'nilai-ujian' && Request::segment(2) === 'dosen') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('nilai-ujian/dosen') }}">Mahasiswa</a>
                                    @endif
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'nilai-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('nilai-ujian/dosen') }}" class="{{ (Request::segment(1) === 'nilai-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-check-double fa-fw"></span> Nilai Ujian
                            </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'nilai-ujian') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('nilai-ujian/mahasiswa') }}" class="{{ (Request::segment(1) === 'nilai-ujian') ? 'text-white' : 'text-dark' }}"><span class="fa fa-check-double fa-fw"></span> Nilai Ujian
                            </a></li>
                        @endif

                        <!-- nilai ujian samping -->
                        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin') || Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'riwayat-skripsi') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('riwayat-skripsi') }}" class="{{ (Request::segment(1) === 'riwayat-skripsi') ? 'text-white' : 'text-dark' }}"><span class="fa fa-history fa-fw"></span> Riwayat Skripsi
                            </a></li>
                        @elseif(Session::has('mahasiswa'))
                            <li class="list-group-item {{ (Request::segment(1) === 'riwayat-skripsi' || Request::segment(1) === 'revisi-skripsi') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'riwayat-skripsi' || Request::segment(1) === 'revisi-skripsi') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-history fa-fw"></span> Riwayat Skripsi
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'riwayat-skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('riwayat-skripsi') }}">Semua</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'revisi-skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('revisi-skripsi') }}">Revisi Saya</a>
                                </li>
                        @endif

                        <!-- mahasiswa samping -->
                        @if(Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'mahasiswa') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('mahasiswa') }}" class="{{ (Request::segment(1) === 'mahasiswa') ? 'text-white' : 'text-dark' }}"><span class="fa fa-users fa-fw"></span> Mahasiswa
                            </a></li>
                        @elseif(Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'mahasiswa') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'mahasiswa') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-users fa-fw"></span> Mahasiswa
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && empty(Request::segment(2))) ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa') }}">Semua</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'akademik') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/akademik') }}">Akademik</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/skripsi') }}">Skripsi</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/kerja-praktek') }}">Kerja Praktek</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'pengujian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/pengujian') }}">Pengujian</a>
                                </li>
                        @elseif(Session::has('dosen'))
                            <li class="list-group-item {{ (Request::segment(1) === 'mahasiswa') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'mahasiswa') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-users fa-fw"></span> Mahasiswa
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'akademik') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/akademik') }}">Akademik</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'skripsi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/skripsi') }}">Skripsi</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'kerja-praktek') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/kerja-praktek') }}">Kerja Praktek</a>
                                    <a class="dropdown-item {{ (Request::segment(1) === 'mahasiswa' && Request::segment(2) === 'pengujian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('mahasiswa/pengujian') }}">Pengujian</a>
                                </li>
                        @endif

                        <!-- semester & periode samping -->
                        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <li class="list-group-item {{ (Request::segment(1) === 'semester-periode') ? 'bg-primary' : 'bg-white' }} dropdown dropright">
                                <a class="{{ (Request::segment(1) === 'semester-periode') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="far fa-calendar-alt fa-fw"></span> Semester & Periode
                                </a>
                                <div class="dropdown-menu">
                                        <a class="dropdown-item {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-ujian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-ujian') }}">Ujian</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-usulan-topik') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-usulan-topik') }}">Usulan Topik</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'periode-daftar-turun-kp') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('semester-periode/periode-daftar-turun-kp') }}">Turun Kerja Praktek</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'semester-periode' && Request::segment(2) === 'semester') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('semester-periode/semester') }}">Semester</a>
                                </li>
                        @endif

                        <!-- dosen samping -->
                        @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'dosen') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('dosen') }}" class="{{ (Request::segment(1) === 'dosen') ? 'text-white' : 'text-dark' }}"><span class="fa fa-chalkboard-teacher fa-fw"></span> Dosen </a></li>
                        @endif

                        <!-- admin samping -->
                        @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'admin') ? 'bg-primary' : 'bg-white' }}"><a href="{{ url('admin') }}" class="{{ (Request::segment(1) === 'admin') ? 'text-white' : 'text-dark' }}"><span class="fa fa-user-secret fa-fw"></span> Admin </a></li>
                        @endif

                        <!-- pengaturan samping -->
                        @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="list-group-item {{ (Request::segment(1) === 'pengaturan') ? 'bg-primary' : 'bg-white' }} dropdown">
                                <a class="{{ (Request::segment(1) === 'pengaturan') ? 'text-white' : 'text-dark' }} dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="fa fa-cogs fa-fw"></span> Pengaturan
                                </a>
                                <div class="dropdown-menu">
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'umum') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pengaturan/umum') }}">Umum</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'pimpinan') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pengaturan/pimpinan') }}">Pimpinan</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'penilaian') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pengaturan/penilaian') }}">Penilaian</a>
                                        <a class="dropdown-item {{ (Request::segment(1) === 'pengaturan' && Request::segment(2) === 'prodi') ? 'bg-primary text-light' : 'text-dark' }}" href="{{ url('pengaturan/prodi') }}">Prodi</a>
                                </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9 my-2">
                <!-- pesan info -->
                @if(Session::has('pesan'))
                    <div class="alert alert-info">
                        <strong><span class="fa fa-info-circle"></span> Info!</strong>
                        <br> {{ Session::get('pesan') }}
                    </div>
                @endif

                @if(Session::has('default_password'))
                <div>
                    <div class="alert alert-danger">
                        <strong><span class="fa fa-exclamation-circle"></span> Perhatian!</strong>
                        <br> Sistem mendeteksi <code>Username</code> & <code>Password</code> anda sama, untuk alasan keamanan akun silahkan ganti <code>Password</code> anda di menu <a href="{{ url('profil') }}">Profil</a>.
                    </div>
                </div>
                @endif

                @yield('main')

            </div>

        </div>
    </div>

    <!-- Footer dashboard -->
    <nav class="nav justify-content-center py-0 mb-5 mb-lg-0 border-top bg-primary">

        <a class="nav-link text-light text-center" href="https://drive.google.com/drive/folders/1a_3ow0_WFAU8pT0LpInYfJKekpESsySm" target="_blank"><span class="fa fa-info-circle" style="color:white"></span> Tentang & Panduan</a>

        <a class="nav-link text-light text-center" href="https://ft.ung.ac.id/informatika/index.html" target="_blank"><i class="far fa-copyright"></i>
            2020
            @if(date('Y') !== '2020')
                - {{ date('Y') }}
            @endif

             Teknik Informatika Universitas Negeri Gorontalo</a>

        <a class="nav-link text-light text-center" href="https://github.com/adnankasim/siskp" target="_blank">
            v.{{ env('APP_VER') }} <small>(rev {{ env('APP_REV') }})</small>
        </a>

    </nav>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/js/jquery-3.4.1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script>
    $(document).ready(function () {
        $('.dosen').select2();
        $('.mahasiswa').select2();
        $('.semester').select2();

        $('#modalInfo').modal('show');
        $('#modalInfo2').modal('show');

        tinymce.init({
            selector:'.borang',
            height: 200,
            plugins: "lists",
            toolbar: "numlist bullist"
        });

        $('#fileSatu').change(function(e){
            var fileName = e.target.files[0].name;
            $('#targetSatu').html(fileName);
        });

        $('#fileDua').change(function(e){
            var fileName = e.target.files[0].name;
            $('#targetDua').html(fileName);
        });

        $('#fileTiga').change(function(e){
            var fileName = e.target.files[0].name;
            $('#targetTiga').html(fileName);
        });

        // form pendaftar ujian
        $("#judulLaporanKp").hide();
        $(".formToefl").hide();

        $("#formUjian" ).change(function() {
            let formUjian = $("#formUjian").val();

            if(formUjian === 'kerja-praktek'){
                $("#judulLaporanKp").show(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'proposal'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'hasil'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'sidang-skripsi'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").show(2000);
            }
        });

            let formUjian = $("#formUjian").val();
            if(formUjian === 'kerja-praktek'){
                $("#judulLaporanKp").show(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'proposal'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'hasil'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").hide(2000);
            }else if(formUjian === 'sidang-skripsi'){
                $("#judulLaporanKp").hide(2000);
                $(".formToefl").show(2000);
            }

    });
    </script>

</body>

</html>
