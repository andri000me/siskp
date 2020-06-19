@extends('template')
@section('main')
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Ketua Jurusan</strong>
                    </div>

                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ !empty($kajur->dosen->nama) ? $kajur->dosen->nama : '-' }}</p>
                                <p class="my-0 py-0 text-dark">
                                    Mulai dari tahun {{ !empty($kajur->tahun_awal) ? $kajur->tahun_awal : '-' }} s/d {{ !empty($kajur->tahun_selesai) ? $kajur->tahun_selesai : '-' }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        @if($kajur)
                                        <a class="nav-link text-success mx-0 px-0 small" href="{{ url('pengaturan/kajur/'. $kajur->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a>
                                        @else
                                        <a class="nav-link text-primary mx-0 px-0 small" href="{{ url('pengaturan/kajur/create') }}"><span class="fa fa-plus"></span>&nbsp; Input</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    @if($kajur)
                                    <a class="dropdown-item" href="{{ url('pengaturan/kajur/'. $kajur->id .'/edit') }}">Edit</a>
                                    @else
                                    <a class="dropdown-item" href="{{ url('pengaturan/kajur/create') }}">Input</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- kaprodi -->
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Ketua Program Studi</strong>
                        
                        <a class="text-white" href="{{ url('pengaturan/kaprodi/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>
                    </div>

                    <!-- jika data ada -->
                    <?php $i=1 ?>
                    @foreach($daftar_kaprodi as $kaprodi)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($kaprodi->dosen->nama) ? $kaprodi->dosen->nama : '-' }} </p>
                                <p class="my-0 py-0 text-dark">
                                    {{ !empty($kaprodi->prodi->nama) ? $kaprodi->prodi->nama : '-' }} <br>
                                    Mulai tahun {{ !empty($kaprodi->tahun_awal) ? $kaprodi->tahun_awal : '-' }} s/d {{ !empty($kaprodi->tahun_selesai) ? $kaprodi->tahun_selesai : '-' }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-success mx-0 px-0 small" href="{{ url('pengaturan/kaprodi/'. $kaprodi->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a>
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
                                            {!! Form::open(['url' => 'pengaturan/kaprodi/'.$kaprodi->id , 'method' => 'delete']) !!}
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
                                    <a class="dropdown-item" href="{{ url('pengaturan/kaprodi/'. $kaprodi->id .'/edit') }}">Edit</a>
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modalKedua{{ $i }}">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                </div>
@stop