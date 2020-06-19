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
                        {!! Form::open(['url' => 'mahasiswa/skripsi/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
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
                                    <label for="">Kontrak Skripsi</label>
                                    {!! Form::select('kontrak_skripsi', ['ya' => 'YA', 'tidak' => 'TIDAK'], (!empty($kontrak_skripsi) ? $kontrak_skripsi : null), ['placeholder' => 'Kontrak Skripsi ?', 'class' => 'form-control']) !!}
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
                                    <a href="{{ url('mahasiswa/skripsi/export?' . 
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
                        <strong class="bg-primary text-light">Daftar Bimbingan Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_skripsi as $skripsi)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $skripsi->mahasiswa->nama }} ({{ $skripsi->mahasiswa->nim  }}) </p>
                                <p class="my-0 py-0">
                                    {{ !empty($skripsi->mahasiswa->prodi->nama) ? $skripsi->mahasiswa->prodi->nama : '-' }} ({{ $skripsi->mahasiswa->angkatan }}) <br>

                                    <span class="text-capitalize">Tahapan Skripsi: {{ str_replace('_', ' ', $skripsi->mahasiswa->tahapan_skripsi) }}</span> <br> 
                                    
                                    @if($skripsi->mahasiswa->kontrak_skripsi === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Kontrak Skripsi</span> 
                                    @elseif($skripsi->mahasiswa->kontrak_skripsi === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak Skripsi</span> 
                                    @endif
                                        <br>
                                    @if($skripsi->dosbingSatuSkripsi->id === Session::get('id'))
                                        Pembimbing: Utama 
                                    @else
                                        Pembimbing: Pendamping 
                                    @endif
                                     <br>
                                     Semester: {{ !empty($skripsi->semester->nama) ? $skripsi->semester->nama : '-' }}
                                     <br>
                                     {{ !empty($skripsi->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $skripsi->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }} <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('mahasiswa/'. $skripsi->mahasiswa->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('mahasiswa/'. $skripsi->mahasiswa->id) }}">Detail</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_skripsi->onEachSide(1)->links() }}
                </nav>
@stop