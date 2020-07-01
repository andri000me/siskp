@extends('template')
@section('main')
                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Periode Daftar Turun Kerja Praktek</strong>
                        
                        <a class="text-white" href="{{ url('semester-periode/periode-daftar-turun-kp/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>
                    </div>

                    <!-- jika data ada -->
                    <?php $i=1 ?>
                    @foreach($daftar_periode_daftar_turun_kp as $periode)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0 text-capitalize">{{ $i }}). {{ $periode->nama  }} </p>
                                <p class="my-0 py-0 text-dark">
                                    Dari Hari {{ tanggal($periode->waktu_buka) }} s/d Hari {{ tanggal($periode->waktu_tutup) }} <br>
                                    Semester {{ !empty($periode->semester->nama) ? $periode->semester->nama : '-' }} <br>
                                    Pendaftar : {{ number_format($periode->pendaftarTurunKp->count(), 0, ',', '.') }} Mahasiswa
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-success mx-0 px-0 small" href="{{ url('semester-periode/periode-daftar-turun-kp/'. $periode->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a>
                                    </li>
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modalKedua{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('semester-periode/periode-daftar-turun-kp/'. $periode->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modalKedua{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modalKedua{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus Periode Daftar Turun KP <strong>{{ $periode->nama }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'semester-periode/periode-daftar-turun-kp/'.$periode->id , 'method' => 'delete', 'class' => 'col']) !!}
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

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_periode_daftar_turun_kp->onEachSide(1)->links() }}
                </nav>
@stop