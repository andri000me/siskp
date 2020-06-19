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
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-warning mx-0 px-0 small" href="{{ url('persetujuan-ujian/' . $persetujuan->id . '/cetak') }}"><span class="fa fa-download"></span>&nbsp; Unduh</a></li>
                                    @else
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-secondary mx-0 px-0 small"><span class="fa fa-download"></span>&nbsp; Unduh</a></li>
                                    @endif
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp;Hapus</a></li>    
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    @if($persetujuan->status_dosbing_dua === 'disetujui' && $persetujuan->status_dosbing_satu === 'disetujui')
                                        <a class="dropdown-item" href="{{ url('persetujuan-ujian/' . $persetujuan->id . '/cetak') }}">Unduh</a>
                                    @else
                                        <a class="dropdown-item">Unduh</a>
                                    @endif
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}">Hapus</a>
                                </div>
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
                                            {!! Form::open(['url' => 'persetujuan-ujian/'.$persetujuan->id , 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
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
                
@stop