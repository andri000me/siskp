@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- pimpinan -->
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                
                <p class="mb-2">Total Data: <strong >{{ $daftar_bimbingan->count() }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Progress Bimbingan <span class="">{{ str_replace('-', ' ', $jenis) }}</span> Semua Mahasiswa</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_bimbingan as $bimbingan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $bimbingan->mahasiswa->nama }} ({{ $bimbingan->mahasiswa->nim }})</p>
                                <p class="my-0 py-0">
                                    {{ $bimbingan->mahasiswa->prodi->nama }} ({{ $bimbingan->mahasiswa->angkatan }})<br>
                                    {{ $bimbingan->total }} kali bimbingan
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_bimbingan->onEachSide(1)->links() }}
                </nav>

                <!-- mahasiswa -->
                @elseif(Session::has('mahasiswa'))
                
                <p class="mb-2">Total Data: <strong >{{ $daftar_bimbingan->count() }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Progress Bimbingan <span class="">{{ str_replace('-', ' ', $jenis) }}</span> Saya</strong>

                        @if($jenis === 'proposal')                        
                        <a class="text-white" href="{{ url('bimbingan/create-proposal') }}"><span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span></a>
                        @elseif($jenis === 'hasil')                        
                        <a class="text-white" href="{{ url('bimbingan/create-hasil') }}"><span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span></a>
                        @elseif($jenis === 'sidang-skripsi')
                        <a class="text-white" href="{{ url('bimbingan/create-sidang-skripsi') }}"><span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span></a>
                        @else
                        <a class="text-white" href="{{ url('bimbingan/create-kerja-praktek') }}"><span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span></a>
                        @endif                        

                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_bimbingan as $bimbingan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ tanggal($bimbingan->waktu) }}</p>
                                <p class="my-0 py-0">
                                    {{ $bimbingan->konsultasi }} <br>
                                    ke {{ $bimbingan->dosen->nama }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    @if($jenis === 'proposal')
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-proposal') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>
                                    @elseif($jenis === 'hasil')
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-hasil') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>
                                    @elseif($jenis === 'sidang-skripsi')
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-sidang-skripsi') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>
                                    @else
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-kerja-praktek') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>
                                    @endif

                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a></li>
                                        
                                </ul>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modal{{ $i }}" tabindex="-1">
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
                                            {!! Form::open(['url' => 'bimbingan/'.$bimbingan->id , 'method' => 'delete']) !!}
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
                                    @if($jenis === 'proposal')
                                    <a class="dropdown-item" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-proposal') }}">Edit</a>
                                    @elseif($jenis === 'hasil')
                                    <a class="dropdown-item" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-hasil') }}">Edit</a>
                                    @elseif($jenis === 'sidang-skripsi')
                                    <a class="dropdown-item" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-sidang-skripsi') }}">Edit</a>
                                    @else
                                    <a class="dropdown-item" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-kerja-praktek') }}">Edit</a>
                                    @endif
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>
                @endif
                
                <!-- dosen -->
                @if(!empty($daftar_masbing))

                <p class="mb-2">Total Data: <strong >{{ $daftar_masbing->count() }}</strong><br></p>
                
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Progress Bimbingan <span class="">{{ str_replace('-', ' ', $jenis) }}</span> Mahasiswa Bimbingan</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_masbing as $bimbingan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $bimbingan->mahasiswa->nama }} ({{ $bimbingan->mahasiswa->nim }})</p>
                                <p class="my-0 py-0">
                                    {{ $bimbingan->mahasiswa->prodi->nama }} ({{ $bimbingan->mahasiswa->angkatan }})<br>
                                    {{ $bimbingan->total }} kali bimbingan
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>
                @endif

                
@stop