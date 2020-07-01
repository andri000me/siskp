@extends('template')
@section('main')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Notifikasi</strong>
                        
                        <a class="text-white d-lg-none" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheet"><span class="fa fa-ellipsis-h"></span></a>

                        <a class="text-white d-none d-lg-inline" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg"><span class="fa fa-ellipsis-h"></span></a>
                    </div>
                </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#semuaDibaca" data-dismiss="modal"><i class="fa fa-fw fa-check-double"></i> Tandai Semua Sudah Dibaca</a></p>
                                            
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusDibaca" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus Yang Sudah Dibaca</a></p>
                                            
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusSemua" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus Semua</a></p>

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
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#semuaDibaca" data-dismiss="modal"><i class="fa fa-fw fa-check-double"></i> Tandai Semua Sudah Dibaca</a></p>
                                            
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusDibaca" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus Yang Sudah Dibaca</a></p>
                                            
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapusSemua" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus Semua</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal semua dibaca -->
                            <div class="modal fade" id="semuaDibaca" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Tandai semua notifikasi sudah dibaca ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'notifikasi/semua-dibaca', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus dibaca -->
                            <div class="modal fade" id="hapusDibaca" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus semua notifikasi yang sudah dibaca ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'notifikasi/hapus-dibaca', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus semua -->
                            <div class="modal fade" id="hapusSemua" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus semua notifikasi yang sudah dibaca ataupun yang belum dibaca ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'notifikasi/hapus-semua', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                @foreach($daftar_notifikasi as $notif)
                    @if($notif->dibaca === 'ya')
                    <div class="card-body border-bottom py-2 bg-white text-dark">
                    @else
                    <div class="card-body border-bottom py-2 bg-primary text-white">
                    @endif
                        <div class="row">

                            <div class="col-12 col-lg-12">
                                <p class="card-title font-weight-bold my-0 py-0 text-capitalize">
                                @if($notif->jenis === 'pendaftaran') <span class="fa fa-edit fa-fw"></span>
                                @elseif($notif->jenis === 'dosen-pembimbing') <span class="fa fa-user-friends fa-fw"></span>
                                @elseif($notif->jenis === 'profil') <span class="fa fa-user-circle fa-fw"></span>
                                @elseif($notif->jenis === 'jadwal-ujian') <span class="fa fa-clock fa-fw"></span>
                                @elseif($notif->jenis === 'nilai-ujian') <span class="fa fa-check-double fa-fw"></span>
                                @elseif($notif->jenis === 'asistensi') <span class="fa fa-comments fa-fw"></span>
                                @elseif($notif->jenis === 'riwayat-skripsi') <span class="fa fa-history fa-fw"></span>
                                @elseif($notif->jenis === 'persetujuan-ujian') <span class="fa fa-user-check fa-fw"></span>
                                @endif 
                                {{ str_replace('-', ' ', $notif->jenis) }}</p>
                                <p class="my-0 py-0 text-capitalize">
                                    {!! $notif->deskripsi !!} <br>
                                <small><em>{{ selisih_waktu($notif->created_at) }}</em></small>
                                </p>

                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link {{ ($notif->dibaca === 'ya') ? 'text-primary' : 'text-white' }} mx-0 px-0 small" href="{{ url('notifikasi/' . $notif->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                    
                                    <li class="nav-item mx-0 px-0"><a class="nav-link {{ ($notif->dibaca === 'ya') ? 'text-primary' : 'text-white' }} mx-0 px-0 small" href="{{ url('notifikasi/' . $notif->id) }}">
                                    <span class="fa {{ ($notif->dibaca === 'ya') ? 'text-primary fa-check' : 'text-white fa-eye-slash' }}"></span>&nbsp; {{ ($notif->dibaca === 'ya') ? 'Dibaca' : 'Belum Dibaca' }}</a>
                                    </li>
                                    
                                </ul>
                            </div>

                        </div>
                    </div>
                @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_notifikasi->onEachSide(1)->links() }}
                </nav>
@stop