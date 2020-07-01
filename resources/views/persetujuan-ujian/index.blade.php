@extends('template')
@section('main')
            @include('errors.form_error')
                
                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Persetujuan Ujian</small>
                        </strong>
                        <a class="text-white" href="{{ url('persetujuan-ujian/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>
                    </div>
                <!-- jika data ada -->
                <?php $i=1 ?>
                @foreach($daftar_persetujuan as $persetujuan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-capitalize my-0 py-0">{{ $i }}). {{ str_replace('-', ' ', $persetujuan->ujian) }}</p>
                                <p class="my-0 py-0 text-capitalize">
                                    @if($persetujuan->status_dosbing_satu === 'belum-diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                    @elseif($persetujuan->status_dosbing_satu === 'disetujui')
                                        <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                    @elseif($persetujuan->status_dosbing_satu === 'tidak-disetujui')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                    @endif
                                    oleh {{ !empty($persetujuan->dosbingSatuAproval->nama) ? $persetujuan->dosbingSatuAproval->nama : '-' }}
                                    
                                    <br>
                                    
                                    @if($persetujuan->status_dosbing_dua === 'belum-diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                    @elseif($persetujuan->status_dosbing_dua === 'disetujui')
                                        <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                    @elseif($persetujuan->status_dosbing_dua === 'tidak-disetujui')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                    @endif
                                    oleh {{ !empty($persetujuan->dosbingDuaAproval->nama) ? $persetujuan->dosbingDuaAproval->nama : '-' }}
                                    <br>
                                    <span class="small"><em>({{ selisih_waktu($persetujuan->created_at) }})</em></span>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    @if($persetujuan->status_dosbing_dua === 'disetujui' && $persetujuan->status_dosbing_satu === 'disetujui')
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-dark mx-0 px-0 small" href="{{ url('persetujuan-ujian/' . $persetujuan->id . '/cetak') }}"><span class="fa fa-download"></span>&nbsp; Unduh</a></li>
                                    @endif
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp;Hapus</a></li>    
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
                                            @if($persetujuan->status_dosbing_dua === 'disetujui' && $persetujuan->status_dosbing_satu === 'disetujui')
                                               <p><a class="d-block text-dark" href="{{ url('persetujuan-ujian/' . $persetujuan->id . '/cetak') }}"><i class="fa fa-download"></i> Unduh</a></p>
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
                                                Yakin menghapus permintaan persetujuan ujian <strong>{{ ucwords(str_replace('-', ' ', $persetujuan->ujian)) }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'persetujuan-ujian/'.$persetujuan->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                
@stop