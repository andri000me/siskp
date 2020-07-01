@extends('template')
@section('main')
                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm mb-2 btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(3) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'mahasiswa/akademik/cari', 'method' => 'get']) !!}
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
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'YA', 'tidak' => 'TIDAK'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-6">
                                    <label for="">Kontrak Kerja Praktek</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'YA', 'tidak' => 'TIDAK'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak Kerja Praktek ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('mahasiswa/akademik/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_kp=' . Request::get('tahapan_kp') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_kp=' . Request::get('kontrak_kp') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi')
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Daftar Pendampingan Akademik</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_pa as $mahasiswa)
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
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'. $mahasiswa->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('mahasiswa/'. $mahasiswa->id) }}">
                                    <span class="fa fa-info-circle fa-lg"></span>&nbsp; Detail
                                </a>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_pa->onEachSide(1)->links() }}
                </nav>
@stop