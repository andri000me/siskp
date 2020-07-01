@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(3) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'nilai-ujian/skripsi/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Program Studi', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('nilai-ujian/skripsi/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_prodi=' . Request::get('id_prodi')
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Nilai Skripsi</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_nilai_skripsi as $nilai)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($nilai->mahasiswa->nama) ? $nilai->mahasiswa->nama : '-' }} ({{ !empty($nilai->mahasiswa->nim) ? $nilai->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0">
                                    {{ !empty($nilai->mahasiswa->prodi->nama) ? $nilai->mahasiswa->prodi->nama : '-' }} ({{ !empty($nilai->mahasiswa->angkatan) ? $nilai->mahasiswa->angkatan : '-' }}) <br>
                                    Seminar Proposal: {{ !empty($nilai->seminar_proposal) ? $nilai->seminar_proposal : '-' }} 
                                    <br> 
                                    Seminar Hasil: {{ !empty($nilai->seminar_hasil) ? $nilai->seminar_hasil : '-' }} 
                                    <br>
                                    Sidang Skripsi: {{ !empty($nilai->sidang_skripsi) ? $nilai->sidang_skripsi : '-' }} <br> 
                                    Total Nilai: {{ !empty($nilai->total) ? $nilai->total : '-' }} 
                                    <br>
                                    Nilai Huruf: {{ $nilai->nilai_huruf }}
                                    <br> 
                                    @if($nilai->total >= 60)
                                        <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                    @else
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Lulus</span>
                                    @endif
                                    <br>
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

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-proposal') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Seminar Proposal</a></p>
                                            
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-hasil') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Seminar Hasil</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-sidang-skripsi') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Sidang Skripsi</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/create-by-admin/' . $nilai->id_mahasiswa) }}"><i class="fa fa-fw fa-plus"></i> Input Nilai Skripsi</a></p>

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
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-proposal') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Seminar Proposal</a></p>
                                            
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-hasil') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Seminar Hasil</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$nilai->id_mahasiswa.'/detail-sidang-skripsi') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Sidang Skripsi</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/create-by-admin/' . $nilai->id_mahasiswa) }}"><i class="fa fa-fw fa-plus"></i> Input Nilai Skripsi</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
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
                    {{ $daftar_nilai_skripsi->onEachSide(1)->links() }}
                </nav>
@stop