@extends('template')
@section('main')
                <!-- total berkas yang belum divalidasi -->
                @if($total_berkas)
                <div class="alert alert-warning">
                    <strong><span class="fa fa-info-circle"></span> Info!</strong> 
                    <br> Anda Punya {{ $total_berkas }} Berkas Yang Harus Di Validasi
                </div>
                @endif

                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(5) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'pendaftaran/ujian/periode/'. $id .'/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Ujian</label>
                                    {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], !empty($ujian) ? $ujian : null, ['class' => 'custom-select', 'placeholder' => '-- Jenis Ujian --']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Program Studi', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        
                            {!! Form::hidden('id_periode_daftar_ujian', $id) !!}

                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('pendaftaran/ujian/periode/'. $id .'/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&ujian=' . Request::get('ujian') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_periode_daftar_ujian=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ $total }}</span></a>
                    
                    <a class="text-dark d-lg-none" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheet"><span class="fa fa-ellipsis-h"></span></a>

                    <a class="text-dark d-none d-lg-inline" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg"><span class="fa fa-ellipsis-h"></span></a>
                </nav>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/' . $id . '/input-by-admin') }}"><i class="fa fa-plus fa-fw"></i> Input pendaftar ujian</a></p>

                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#setujui" data-dismiss="modal"><i class="fa fa-fw fa-check"></i> Setujui semua berkas</a></p>

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
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/' . $id . '/input-by-admin') }}"><i class="fa fa-plus fa-fw"></i> Input pendaftar ujian</a></p>

                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#setujui" data-dismiss="modal"><i class="fa fa-fw fa-check"></i> Setujui semua berkas</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal setujui semua -->
                            <div class="modal fade" id="setujui" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-primary text-center pb-3"> <i class="fa fa-info-circle"></i> Konfirmasi</h5>
                                            <p>
                                                Yakin Menyetujui semua berkas pada periode Ujian <strong>{{ $periode->nama }}</strong> ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'pendaftaran/ujian/setujui-semua', 'class' => 'col']) !!}
                                                    {!! Form::hidden('id_periode_daftar_ujian', $id) !!}
                                                    <button type="submit" class="btn btn-block btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Ujian {{ $periode->nama }}</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_ujian as $pendaftar)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-truncate my-0 py-0">{{ $i }}). {{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0 text-capitalize text-truncate">
                                    @if($pendaftar->ujian !== 'sidang-skripsi')
                                        Ujian Seminar {{ str_replace('-', ' ', $pendaftar->ujian) }}
                                    @else
                                        Ujian {{ str_replace('-', ' ', $pendaftar->ujian) }} 
                                    @endif
                                    <br>
                                    
                                    @if($pendaftar->ujian !== 'kerja-praktek')
                                        Judul: {{ !empty($pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}<br>
                                    @else
                                        Judul: {{ !empty($pendaftar->judul_laporan_kp) ? $pendaftar->judul_laporan_kp : '-' }}<br>
                                    @endif

                                    @if($pendaftar->tahapan === 'diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                    @elseif($pendaftar->tahapan === 'diterima')
                                        <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                    @elseif($pendaftar->tahapan === 'ditolak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                    @elseif($pendaftar->tahapan === 'dibatalkan')
                                        <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                    @endif
                                    <br>
                                    @if($pendaftar->ujian !== 'kerja-praktek')
                                        Pembimbing Skripsi: <br>
                                        @if(!blank($pendaftar->mahasiswa->dosenPembimbingSkripsi))
                                            1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                            2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }}
                                        @else
                                            - 
                                        @endif
                                    @else
                                        Pembimbing KP: <br>
                                        @if(!blank($pendaftar->mahasiswa->dosenPembimbingKp))
                                            1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ?  $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                            2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ?   $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }}
                                        @else
                                            - 
                                        @endif
                                    @endif
                                    <br>
                                    <span class="small"><em>{{ selisih_waktu($pendaftar->created_at) }}</em></span>
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
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/'.$pendaftar->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/'.$pendaftar->id.'/create-jadwal') }}"><i class="fa fa-fw fa-plus"></i> Input jadwal ujian</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

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
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/'.$pendaftar->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/ujian/'.$pendaftar->id.'/create-jadwal') }}"><i class="fa fa-fw fa-plus"></i> Input jadwal ujian</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

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
                                                Yakin menghapus <strong>{{ $pendaftar->mahasiswa->nama }} ({{ $pendaftar->mahasiswa->nim }})</strong> pada ujian <strong>{{ ucwords(str_replace('-', ' ', $pendaftar->ujian)) }}</strong> dari periode daftar ujian <strong>{{ $pendaftar->periodeDaftarUjian->nama }}</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'pendaftaran/ujian/'.$pendaftar->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                    {{ $daftar_ujian->onEachSide(1)->links() }}
                </nav>
@stop