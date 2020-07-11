@extends('template')
@section('main')
                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ number_format($total, 0, ',', '.') }}</span></a>
                </nav>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Persetujuan Ujian Bulan
                        @switch($bulan)
                            @case(1) Januari @break
                            @case(2) Februari @break
                            @case(3) Maret @break
                            @case(4) April @break
                            @case(5) Mei @break
                            @case(6) Juni @break
                            @case(7) Juli @break
                            @case(8) Agustus @break
                            @case(9) September @break
                            @case(10) Oktober @break
                            @case(11) November @break
                            @case(12) Desember @break
                        @endswitch 
                            {{ $tahun }}
                        </strong>
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
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-primary" style="cursor:pointer" data-toggle="modal" data-target="#modalSetujui{{ $i }}" data-dismiss="modal"><i class="fa fa-check"></i> Setujui</a></p>
                                            
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modalTidak{{ $i }}" data-dismiss="modal"><i class="fa fa-ban"></i> Tidak Setujui</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal setujui -->
                            <div class="modal fade" id="modalSetujui{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-primary text-center pb-3"> <i class="fa fa-info-circle"></i> Konfirmasi</h5>
                                            <p>
                                                Yakin menyetujui permohonan ujian <strong>{{ ucwords(str_replace('-', ' ', $persetujuan->ujian)) }}</strong> dari <strong>{{ $persetujuan->mahasiswa->nama }} ({{ $persetujuan->mahasiswa->nim }})</strong> ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'persetujuan-ujian/' . $persetujuan->id . '/disetujui', 'class' => 'col']) !!}
                                                    {!! Form::hidden('tanggal', $tahun . '-' . $bulan) !!}
                                                    <button type="submit" class="btn btn-block btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal tidak disetujui -->
                            <div class="modal fade" id="modalTidak{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin tidak menyetujui permohonan ujian <strong>{{ ucwords(str_replace('-', ' ', $persetujuan->ujian)) }}</strong> dari <strong>{{ $persetujuan->mahasiswa->nama }} ({{ $persetujuan->mahasiswa->nim }})</strong> ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'persetujuan-ujian/' . $persetujuan->id . '/tidak-disetujui', 'class' => 'col']) !!}
                                                    {!! Form::hidden('tanggal', $tahun . '-' . $bulan) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
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
                    {{ $daftar_persetujuan->onEachSide(1)->links() }}
                </nav>
@stop