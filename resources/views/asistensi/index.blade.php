@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Asistensi Online Saya</strong>
                        
                        @if(Session::has('bisa_kp'))
                        <a class="text-white small d-none d-lg-flex" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg"><span class="fa fa-plus fa-lg"></span></a>

                        <a class="text-white small d-lg-none" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheet"><span class="fa fa-plus fa-lg"></span></a>
                        @else
                        <a class="text-white" href="{{ url('asistensi/create-skripsi') }}"><span class="fa fa-plus"></span> <span class=""></span></a>   
                        @endif
                    </div>
                        @if(Session::has('bisa_kp'))
                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a href="{{ url('asistensi/create-skripsi') }}" class="d-block text-dark"><i class="fa fa-fw fa-comment"></i> Skripsi (Proposal, Hasil atau Sidang)</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('asistensi/create-kerja-praktek') }}"><i class="fa fa-fw fa-comment"></i> Kerja Praktek</a></p>
                            
                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a href="{{ url('asistensi/create-skripsi') }}" class="d-block text-dark"><i class="fa fa-fw fa-comment"></i> Skripsi (Proposal, Hasil atau Sidang)</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('asistensi/create-kerja-praktek') }}"><i class="fa fa-fw fa-comment"></i> Kerja Praktek</a></p>
                            
                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    <?php $i=1 ?>
                    @foreach($daftar_asistensi as $asistensi)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}).  {{ $asistensi->topik_bimbingan }}</p>
                                <p class="my-0 py-0">
                                    <span class="text-capitalize">Asistensi {{ str_replace('-', ' ', $asistensi->jenis) }} </span> 
                                    <br>
                                    Pada {{ $asistensi->dosen->nama }} <br>
                                    {{ $asistensi->detailAsistensi->count() }} komentar <br>
                                    {{ selisih_waktu($asistensi->created_at) }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>

                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><span class="fa fa-comments"></span>&nbsp; Komentar</a></li>

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
                                            
                                            <p><a class="d-block text-dark" href="{{ url('asistensi/' . $asistensi->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><i class="fa fa-fw fa-comments"></i> Komentar</a></p>

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
                                                Yakin menghapus asistensi dengan topik <strong>{{ $asistensi->topik_bimbingan }}</strong> pada dosen <strong>{{ $asistensi->dosen->nama }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'asistensi/'.$asistensi->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                    {{ $daftar_asistensi->onEachSide(1)->links() }}
                </nav>
                
@stop