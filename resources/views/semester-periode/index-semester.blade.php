@extends('template')
@section('main')
                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Periode Semester</strong>
                        
                        <a class="text-white" href="{{ url('semester-periode/semester/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>
                    </div>

                    <!-- jika data ada -->
                    <?php $i=1 ?>
                    @foreach($daftar_semester as $periode)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0 text-capitalize">{{ $i }}). {{ $periode->nama  }} </p>
                                <p class="my-0 py-0 text-dark">
                                    Dari Hari {{ tanggal($periode->waktu_buka) }} s/d Hari {{ tanggal($periode->waktu_tutup) }} <br>
                                    {{ $periode->periodeDaftarUjian->count() }} Periode Ujian, <br class="d-lg-none">
                                    {{ $periode->periodeDaftarUsulanTopik->count() }} Periode Usulan Topik, <br class="d-lg-none">
                                    {{ $periode->periodeDaftarTurunKp->count() }} Periode Turun Kerja Praktek, <br class="d-lg-none">
                                    {{ $periode->dosenPembimbingSkripsi->count() }} Mahasiswa Skripsi, & <br class="d-lg-none"> 
                                    {{ $periode->dosenPembimbingKp->count() }} Mahasiswa Kerja Praktek <br class="d-lg-none">
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-success mx-0 px-0 small" href="{{ url('semester-periode/semester/'. $periode->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a>
                                    </li>
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modalKedua{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modalKedua{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-light">
                                            <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-dark h6">
                                            Yakin menghapus data ini ? Data yang sudah dihapus tidak bisa dikembalikan.
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['url' => 'semester-periode/semester/'.$periode->id , 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('semester-periode/semester/'. $periode->id .'/edit') }}">Edit</a>
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modalKedua{{ $i }}">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_semester->onEachSide(1)->links() }}
                </nav>
@stop