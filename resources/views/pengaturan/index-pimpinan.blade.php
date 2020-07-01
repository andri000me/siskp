@extends('template')
@section('main')
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Ketua Jurusan</strong>
                        
                        <a class="text-white" href="{{ url('pengaturan/kajur/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>
                    </div>
                    
                    <?php $i=1 ?>
                    @foreach($daftar_kajur as $kajur)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}) {{ !empty($kajur->dosen->nama) ? $kajur->dosen->nama : '-' }}</p>
                                <p class="my-0 py-0 text-dark">
                                    Mulai dari tahun {{ !empty($kajur->tahun_awal) ? $kajur->tahun_awal : '-' }} s/d {{ !empty($kajur->tahun_selesai) ? $kajur->tahun_selesai : '-' }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-success mx-0 px-0 small" href="{{ url('pengaturan/kajur/'. $kajur->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a>
                                    </li>
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#hapusKajur{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a>
                                    </li>
                                </ul>

                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetKajur{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet kajur -->
                            <div class="modal fade" id="sheetKajur{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusKajur{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>
                                            
                                            <p><a class="d-block text-dark" href="{{ url('pengaturan/kajur/'. $kajur->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="hapusKajur{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus <strong>{{ $kajur->dosen->nama }}</strong> sebagai Kajur ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                            
                                                {!! Form::open(['url' => 'pengaturan/kajur/'.$kajur->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                                        <a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#hapusKaprodi{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a>
                                    </li>
                                </ul>

                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetKaprodi{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal hapus kaprodi -->
                            <div class="modal fade" id="hapusKaprodi{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus <strong>{{ $kaprodi->dosen->nama }}</strong> sebagai Kaprodi <strong>{{ $kaprodi->prodi->nama }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                            
                                                {!! Form::open(['url' => 'pengaturan/kaprodi/'.$kaprodi->id , 'method' => 'delete', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet kaprodi -->
                            <div class="modal fade" id="sheetKaprodi{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('pengaturan/kaprodi/'. $kaprodi->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusKaprodi{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                </div>
@stop