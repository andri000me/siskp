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
                        {!! Form::open(['url' => 'mahasiswa/kerja-praktek/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Tahapan KP</label>
                                    {!! Form::select('tahapan_kp', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran' => 'Pendaftaran',
                                    'ujian_seminar' => 'Ujian Seminar',
                                    'revisi' => 'Revisi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_kp) ? $tahapan_kp : null), ['placeholder' => 'Tahapan KP', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Kontrak KP</label>
                                    {!! Form::select('kontrak_kp', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($kontrak_kp) ? $kontrak_kp : null), ['placeholder' => 'Kontrak KP ?', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Pembimbing</label>
                                    {!! Form::select('pembimbing', ['utama' => 'Utama', 'pendamping' => 'Pendamping'], (!empty($pembimbing) ? $pembimbing : 'utama'), ['placeholder' => 'Pembimbing ?', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Semester</label>
                                    {!! Form::select('id_semester', $daftar_semester, (!empty($id_semester) ? $id_semester : null), ['placeholder' => 'Daftar Semester', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('mahasiswa/kerja-praktek/export?' . 
                                     'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&kontrak_skripsi=' . Request::get('kontrak_skripsi') .
                                     '&pembimbing=' . Request::get('pembimbing') .
                                     '&id_semester=' . Request::get('id_semester') 
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Daftar Bimbingan Kerja Praktek</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_kp as $kp)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $kp->mahasiswa->nama }} ({{ $kp->mahasiswa->nim  }}) </p>
                                <p class="my-0 py-0">
                                    {{ !empty($kp->mahasiswa->prodi->nama) ? $kp->mahasiswa->prodi->nama : '-' }} ({{ $kp->mahasiswa->angkatan }}) <br>
                                    
                                    <span class="text-capitalize">Tahapan KP: {{ str_replace('_', ' ', $kp->mahasiswa->tahapan_kp) }}</span> 
                                    <br>
                                    @if($kp->mahasiswa->kontrak_kp === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Kontrak KP</span> 
                                    @elseif($kp->mahasiswa->kontrak_kp === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak KP</span> 
                                    @endif
                                        <br>
                                    @if($kp->dosbingSatuKp->id === Session::get('id'))
                                        Pembimbing: Utama
                                    @else
                                        Pembimbing: Pendamping 
                                    @endif
                                    <br>
                                     Semester: {{ !empty($kp->semester->nama) ? $kp->semester->nama : '-' }} 
                                     <br> {{ $kp->lokasi }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'. $kp->mahasiswa->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('mahasiswa/'. $kp->mahasiswa->id) }}">
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
                    {{ $daftar_kp->onEachSide(1)->links() }}
                </nav>
@stop