@extends('template')
@section('main')
            @include('errors.form_error')

            <!-- akordion -->
                    <div class="col-12 mb-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-info-circle"></span> Syarat & Ketentuan </button>
                            <div id="pencarian" class="collapse my-2 pb-1" data-parent="#filter">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <p class="my-0 py-0">
                                            Persyaratan akademik yang harus dipenuhi oleh mahasiswa untuk dapat mendaftar <strong>Turun Kerja Praktek</strong> adalah sebagai berikut: <br>
                                            1). Mengontrak Mata Kuliah Kerja Praktek. <small><a href="{{ url('profil') }}">Cek disini</a> </small> <br>
                                            2). Dosen Pembimbing Akademik telah anda diinputkan ke Sistem. <small><a href="{{ url('profil') }}">Cek disini</a> </small> <br>
                                            4). Program Studi telah anda diinputkan ke Sistem. <small><a href="{{ url('profil') }}">Cek disini</a> </small> <br>
                                        </p> <br>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

            @if(empty($periode_aktif))
                <div class="card mb-2">
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12">
                                <p class="card-title h6 text-center font-weight-bold my-0 py-3">
                                    Periode Pendaftaran Turun Kerja Praktek Belum Ada Yang Dibuka!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ $total }}</span></a>
                    
                    <a class="text-primary" href="{{ url('pendaftaran/turun-kp/create?id='.$periode_aktif->id) }}"><span class="fa fa-edit"></span> <span class="">Daftar</span></a>
                </nav>

                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Periode Turun Kerja Praktek {{ $periode_aktif->nama }}  
                        <br> <small> Dari Hari {{ tanggal($periode_aktif->waktu_buka) }} s/d Hari {{ tanggal($periode_aktif->waktu_tutup) }} </small>
                        </strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>
                <!-- jika data ada -->
                <?php $i=1 ?>
                @foreach($daftar_pendaftar as $pendaftar)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-truncate my-0 py-0">{{ $i }}). {{ $pendaftar->mahasiswa->nama }} ({{ $pendaftar->mahasiswa->nim }})</p>
                                <p class="my-0 py-0 text-capitalize text-truncate">
                                    
                                    {{ $pendaftar->instansi }}<br>
                                    <small>{{ $pendaftar->alamat }}</small> <br>
                                    
                                    @if($pendaftar->tahapan === 'diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                    @elseif($pendaftar->tahapan === 'diterima')
                                        <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                    @elseif($pendaftar->tahapan === 'ditolak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                    @elseif($pendaftar->tahapan === 'dibatalkan')
                                        <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                    @endif
                                    <br>
                                    <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/turun-kp/'.$pendaftar->id) }}"><span
                                                    class="fa fa-info-circle"></span>&nbsp;
                                                Detail</a></li>
                                        
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('pendaftaran/turun-kp/'.$pendaftar->id) }}">
                                    <span class="fa fa-info-circle fa-lg"></span> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach
                </div>
                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_pendaftar->onEachSide(1)->links() }}
                </nav>
            @endif

            @if(Session::has('mahasiswa'))
                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Riwayat Turun Kerja Praktek Saya</small>
                        </strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>
                <!-- jika data ada -->
                <?php $i=1 ?>
                @foreach($daftar_turun_kp as $pendaftar)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-capitalize text-truncate my-0 py-0">{{ $i }}). {{ $pendaftar->instansi }}</p>
                                <p class="my-0 py-0 text-capitalize">
                                    {{ $pendaftar->alamat }} <br>
                                    Periode {{ !empty($pendaftar->periodeDaftarTurunKp->nama) ? $pendaftar->periodeDaftarTurunKp->nama : '-' }} <br>
                                    @if($pendaftar->tahapan === 'diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                    @elseif($pendaftar->tahapan === 'diterima')
                                        <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                    @elseif($pendaftar->tahapan === 'ditolak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                    @elseif($pendaftar->tahapan === 'dibatalkan')
                                        <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                    @endif
                                    <br>
                                    <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/turun-kp/'.$pendaftar->id) }}"><span class="fa fa-info-circle"></span>&nbsp;
                                                Detail</a></li>
                                        
                                        @if($pendaftar->tahapan === 'diperiksa')
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('pendaftaran/turun-kp/'. $pendaftar->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp;
                                                Edit</a></li>
                                        
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp;Hapus</a></li>
                                        @endif
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/turun-kp/'.$pendaftar->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            @if($pendaftar->tahapan === 'diperiksa')
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/turun-kp/'. $pendaftar->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>
                                            @endif

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modal{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus berkas turun kerja praktek anda dari periode <strong>{{ $pendaftar->periodeDaftarTurunKp->nama }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'pendaftaran/turun-kp/'.$pendaftar->id ,'method' => 'delete', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach
                </div>
                
            @endif
@stop