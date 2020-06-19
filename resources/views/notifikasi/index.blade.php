@extends('template')
@section('main')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Notifikasi</strong>
                        <div class="dropdown dropleft">
                        <a class="text-white dropdown-toggle caret-off" href="#" data-toggle="dropdown"><span class="fa fa-ellipsis-h"></span> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#semuaDibaca">Tandai Semua Sudah Dibaca</a>
                            <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#hapusDibaca">Hapus Yang Sudah Dibaca</a>
                            <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#hapusSemua">Hapus Semua</a>
                        </div>
                    </div>
                </div>

                <!-- modal semua dibaca -->
                <div class="modal fade" id="semuaDibaca" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title"> <i class="fa fa-info"></i> Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body text-dark h6">
                                Yakin semua sudah dibaca ?
                            </div>
                            <div class="modal-footer">
                                {!! Form::open(['url' => 'notifikasi/semua-dibaca']) !!}
                                    <button type="submit" class="btn btn-link btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal hapus dibaca -->
                <div class="modal fade" id="hapusDibaca" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body text-dark h6">
                                Yakin menghapus semua yang sudah dibaca ?
                            </div>
                            <div class="modal-footer">
                                {!! Form::open(['url' => 'notifikasi/hapus-dibaca']) !!}
                                    <button type="submit" class="btn btn-link btn-danger btn-sm text-white"><i class="fa fa-trash"></i> Hapus</button>
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal hapus semua -->
                <div class="modal fade" id="hapusSemua" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body text-dark h6">
                                Yakin menghapus semua notifikasi ?
                            </div>
                            <div class="modal-footer">
                                {!! Form::open(['url' => 'notifikasi/hapus-semua']) !!}
                                    <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
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