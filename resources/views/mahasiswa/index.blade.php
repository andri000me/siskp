@extends('template')
@section('main')
                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm mb-2 btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(2) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'mahasiswa/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
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
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Tahapan Skripsi</label>
                                    {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revis Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Tahapan Skripsi', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Tahapan Kerja Praktek</label>
                                    {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran Ujian',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan Kerja Praktek', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Dosen Pendampingan Akademik</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, (!empty($id_dosen) ? $id_dosen : null), ['placeholder' => 'Daftar Dosen PA', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                @if(!Session::has('kaprodi'))
                                <div class="form-group col-4">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                                @endif

                                @if(!Session::has('kaprodi'))
                                <div class="form-group col-4">
                                @else
                                <div class="form-group col-6">
                                @endif
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'YA', 'tidak' => 'TIDAK'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
                                </div>

                                @if(!Session::has('kaprodi'))
                                <div class="form-group col-4">
                                @else
                                <div class="form-group col-6">
                                @endif
                                    <label for="">Kontrak Kerja Praktek</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'YA', 'tidak' => 'TIDAK'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak Kerja Praktek ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('mahasiswa/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_kp=' . Request::get('tahapan_kp') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_dosen=' . Request::get('id_dosen') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_kp=' . Request::get('kontrak_kp') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ number_format($total, 0, ',', '.') }}</span></a>
                    
                    <a class="text-dark d-lg-none" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetNon"><span class="fa fa-ellipsis-h"></span></a>

                    <a class="text-dark d-none d-lg-inline" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetNonLg"><span class="fa fa-ellipsis-h"></span></a>
                </nav>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetNonLg" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/import') }}"><i class="fa fa-fw fa-upload"></i> Import Mahasiswa Skripsi & KP</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/import-maba') }}"><i class="fa fa-fw fa-plus"></i> Import Mahasiswa Baru </a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#non" data-dismiss="modal"> <i class="fa fa-fw fa-ban"></i> Off kan status mahasiswa yang telah lulus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheetNon" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/import') }}"><i class="fa fa-fw fa-upload"></i> Import Mahasiswa Skripsi & KP</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/import-maba') }}"><i class="fa fa-fw fa-plus"></i> Import Mahasiswa Baru </a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#non" data-dismiss="modal"> <i class="fa fa-fw fa-ban"></i> Off kan status yg telah lulus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal non aktifkan semua status -->
                            <div class="modal fade" id="non" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menon-aktifkan status Kontrak Skripsi & Kontrak Kerja Praktek semua mahasiswa yang telah lulus ? Mahasiswa yang telah dinonaktifkan statusnya tidak bisa lagi menggunakan sistem dengan optimal
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'mahasiswa/nonaktifkan-semua-lulus', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Daftar Mahasiswa</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_mahasiswa as $mahasiswa)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $mahasiswa->nama }} ({{ $mahasiswa->nim  }}) </p>
                                <p class="my-0 py-0">
                                    {{ !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-' }} ({{ $mahasiswa->angkatan }}) <span class="d-none d-lg-inline">|</span> <br class="d-lg-none">
                                    
                                    <span class="text-capitalize">Tahapan Skripsi: {{ str_replace('_', ' ', $mahasiswa->tahapan_skripsi) }}</span> <span class="d-none d-lg-inline">|</span> <br class="d-lg-none">
                                    
                                    <span class="text-capitalize">Tahapan KP: {{ str_replace('_', ' ', $mahasiswa->tahapan_kp) }}</span> <br>
                                    
                                    @if($mahasiswa->kontrak_skripsi === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Kontrak Skripsi</span> <span class="d-none d-lg-inline">|</span>
                                    @elseif($mahasiswa->kontrak_skripsi === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak Skripsi</span> <span class="d-none d-lg-inline">|</span>
                                    @endif
                                    &nbsp;

                                    @if($mahasiswa->kontrak_kp === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Kontrak KP</span> <span class="d-none d-lg-inline">|</span>
                                    @elseif($mahasiswa->kontrak_kp === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak KP</span> <span class="d-none d-lg-inline">|</span>
                                    @endif
                                    <br class="d-lg-none">
                                    {{ !empty($mahasiswa->dosen->nama) ? $mahasiswa->dosen->nama : '-' }} <br>

                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'. $mahasiswa->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                        
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('mahasiswa/'. $mahasiswa->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>

                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-dark mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}"><span class="fa fa-cog"></span>&nbsp; Lainnya</a></li>
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
                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'. $mahasiswa->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'. $mahasiswa->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                    @if(blank($mahasiswa->pendaftarUsulanTopik))
                                        <p><a class="d-block text-dark" href="{{ url('pendaftaran/usulan-topik/create-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-spell-check"></i> Input Judul Skripsi</a></p>
                                    @endif
                                    @if(blank($mahasiswa->hasilAkumulasiNilaiSkripsi))
                                        <p><a class="d-block text-dark" href="{{ url('nilai-ujian/create-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-check-double"></i> Input Nilai Skripsi</a></p>
                                    @else
                                        <p><a class="d-block text-dark" href="{{ url('nilai-ujian/detail-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-eye"></i> Lihat Nilai Skripsi</a></p>
                                    @endif
                                            <p><a class="d-block text-dark" href="{{ url('peserta-ujian/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-street-view"></i> Lihat Peserta Ujian</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapus{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'. $mahasiswa->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'. $mahasiswa->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                    @if(blank($mahasiswa->pendaftarUsulanTopik))
                                        <p><a class="d-block text-dark" href="{{ url('pendaftaran/usulan-topik/create-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-spell-check"></i> Input Judul Skripsi</a></p>
                                    @endif
                                    @if(blank($mahasiswa->hasilAkumulasiNilaiSkripsi))
                                        <p><a class="d-block text-dark" href="{{ url('nilai-ujian/create-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-check-double"></i> Input Nilai Skripsi</a></p>
                                    @else
                                        <p><a class="d-block text-dark" href="{{ url('nilai-ujian/detail-by-admin/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-eye"></i> Lihat Nilai Skripsi</a></p>
                                    @endif
                                            <p><a class="d-block text-dark" href="{{ url('peserta-ujian/'.$mahasiswa->id ) }}"><i class="fa fa-fw fa-street-view"></i> Lihat Peserta Ujian</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapus{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="hapus{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus <strong>{{ $mahasiswa->nama }}</strong> sebagai mahasiswa ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'mahasiswa/'.$mahasiswa->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                    {{ $daftar_mahasiswa->onEachSide(1)->links() }}
                </nav>
@stop