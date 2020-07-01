@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pembimbing KP Anda</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_dosbing as $dosbing)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($dosbing->semester->nama) ? $dosbing->semester->nama : '-' }} </p>
                                <p class="my-0 py-0">
                                    1). {{ $dosbing->dosbingSatuKp->nama }} <br>
                                    2). {{ $dosbing->dosbingDuaKp->nama }} <br>
                                    {{ $dosbing->lokasi }} 
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-dark mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}"><span class="fa fa-cog"></span>&nbsp; Lainnya</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a href="{{ url('dosen-pembimbing/kerja-praktek/surat-penunjukan/'. $dosbing->id_semester ) }}" class="d-block text-dark"><i class="fa fa-fw fa-download"></i> Unduh penunjukan pembimbing</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/form-surat-persetujuan-kp/'.$dosbing->id) }}"><i class="fa fa-fw fa-download"></i> Unduh persetujuan ujian seminar</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a href="{{ url('dosen-pembimbing/kerja-praktek/surat-penunjukan/'. $dosbing->id_semester ) }}" class="d-block text-dark"><i class="fa fa-fw fa-download"></i> Unduh penunjukan pembimbing</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/form-surat-persetujuan-kp/'.$dosbing->id) }}"><i class="fa fa-fw fa-download"></i> Unduh persetujuan ujian seminar</a></p>

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