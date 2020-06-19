@extends('template')
@section('main')
                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ number_format($total, 0, ',', '.') }}</span></a>
                </nav>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Persetujuan Ujian</strong>
                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_persetujuan as $persetujuan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $persetujuan->mahasiswa->nama }} ({{ $persetujuan->mahasiswa->nim }})</p>
                                <p class="my-0 py-0 text-capitalize">
                                    Ujian {{ str_replace('-', ' ', $persetujuan->ujian) }} <br>
                                    
                                    @if($persetujuan->dosbing_satu_aproval === Session::get('id'))
                                        Pembimbing Utama
                                    @else
                                        Pembimbing Pendamping
                                    @endif 
                                    <br>

                                    @if($persetujuan->dosbing_satu_aproval === Session::get('id'))
                                        @if($persetujuan->status_dosbing_satu === 'belum-diperiksa')
                                            <span class="text-dark"><i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                        @elseif($persetujuan->status_dosbing_satu === 'disetujui')
                                            <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                        @elseif($persetujuan->status_dosbing_satu === 'tidak-disetujui')
                                            <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                        @endif
                                    @else
                                        @if($persetujuan->status_dosbing_dua === 'belum-diperiksa')
                                            <span class="text-dark"><i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                        @elseif($persetujuan->status_dosbing_dua === 'disetujui')
                                            <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                        @elseif($persetujuan->status_dosbing_dua === 'tidak-disetujui')
                                            <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                        @endif 
                                    @endif
                                    <br>
                                    <small><em>({{ selisih_waktu($persetujuan->created_at) }})</em></small>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modalSetujui{{ $i }}"><span class="fa fa-check"></span>&nbsp; Setujui</a></li>                                        
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modalTidak{{ $i }}"><span class="fa fa-times"></span>&nbsp; Tidak Disetujui</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modalSetujui{{ $i }}">Setujui</a>
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modalTidak{{ $i }}">Tidak Setujui</a>
                                </div>
                            </div>

                            <!-- modal setujui -->
                            <div class="modal fade" id="modalSetujui{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-light">
                                            <h5 class="modal-title"> <i class="fa fa-info"></i> Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-dark h6">
                                            Yakin menyetujui permohonan ujiannya ?
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['url' => 'persetujuan-ujian/' . $persetujuan->id . '/disetujui']) !!}
                                                <button type="submit" class="btn btn-link btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal tidak disetujui -->
                            <div class="modal fade" id="modalTidak{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-light">
                                            <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-dark h6">
                                            Yakin tidak menyetujui permohonan ujiannya ?
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['url' => 'persetujuan-ujian/' . $persetujuan->id . '/tidak-disetujui']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
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
                    {{ $daftar_persetujuan->onEachSide(1)->links() }}
                </nav>
@stop