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
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}">
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
                                            
                                            @if($jenis === 'proposal')
                                                <p><a class="d-block text-dark" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-proposal') }}"><i class="fa fa-edit"></i> Edit</a></p>
                                            @elseif($jenis === 'hasil')
                                                <p><a class="d-block text-dark" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-hasil') }}"><i class="fa fa-edit"></i> Edit</a></p>
                                            @elseif($jenis === 'sidang-skripsi')
                                                <p><a class="d-block text-dark" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-sidang-skripsi') }}"><i class="fa fa-edit"></i> Edit</a></p>
                                            @else
                                               <p><a class="d-block text-dark" href="{{ url('bimbingan/'. $bimbingan->id .'/edit-kerja-praktek') }}"><i class="fa fa-edit"></i> Edit</a></p>
                                            @endif

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

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
                                                Yakin menghapus bimbingan ujian <strong>{{ ucwords(str_replace('-', ' ', $bimbingan->bimbingan)) }}</strong> di hari {{ tanggal($bimbingan->waktu) }} pada <strong> {{ $bimbingan->dosen->nama }} </strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'bimbingan/'.$bimbingan->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('mahasiswa/'.$bimbingan->id_mahasiswa) }}">
                                    <span class="fa fa-info-circle fa-lg"></span> <br> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>
                @endif

                
@stop