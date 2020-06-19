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
                        {!! Form::open(['url' => 'riwayat-skripsi/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Judul</label>
                                    {!! Form::text('judul', (!empty($judul) ? $judul : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Tahapan</label>
                                    {!! Form::select('tahapan_skripsi', [
                                    'persiapan' => 'Persiapan',
                                    'pendaftaran_topik' => 'Pendaftaran Topik',
                                    'penyusunan_proposal' => 'Penyusunan Proposal',
                                    'pendaftaran_proposal' => 'Pendaftaran Proposal',
                                    'ujian_seminar_proposal' => 'Ujian Seminar Proposal',
                                    'penulisan_skripsi' => 'Penulisan Skripsi',
                                    'pendaftaran_hasil' => 'Pendaftaran Hasil',
                                    'ujian_seminar_hasil' => 'Ujian Seminar Hasil',
                                    'revisi_skripsi' => 'Revisi Skripsi',
                                    'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi',
                                    'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi',
                                    'lulus' => 'Lulus'
                                    ], (!empty($tahapan_skripsi) ? $tahapan_skripsi : null), ['placeholder' => 'Daftar Tahapan Skripsi', 'class' => 'custom-select']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>

                                <div class="col-2">
                                    <a href="{{ url('riwayat-skripsi/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&judul=' . Request::get('judul') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&tahapan_skripsi=' . Request::get('tahapan_skripsi')
                                     )  }}" target="_blank" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel"></i> Export .XLS </a>
                                </div>
                            </div>
                            
                        {!! Form::close() !!}
                    </div>
                </div>
                
                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span class="fa fa-history"></span> Riwayat Skripsi</h6>

                    <!-- jika data ada -->
                    <?php $i=1 ?>
                    @foreach($daftar_pendaftar as $pendaftar)
                    <div class="card-body border-bottom py-2 text-truncate">
                        <strong class="card-title ">{{ $i }}). {{ $pendaftar->mahasiswa->nama }} ({{ $pendaftar->mahasiswa->nim }})</strong> <br>
                        {{ $pendaftar->usulan_judul }}
                        
                        @if($pendaftar->mahasiswa->tahapan_skripsi === 'lulus')
                        <br> <span class="text-primary text-capitalize"> <i class="fa fa-check"></i> {{ str_replace('_', ' ', $pendaftar->mahasiswa->tahapan_skripsi) }} </span>
                        @else
                        <br> <span class="text-dark text-capitalize"> <i class="fa fa-hourglass-half"></i> {{ str_replace('_', ' ', $pendaftar->mahasiswa->tahapan_skripsi) }}</span>
                        @endif
                        
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item mx-0 px-0">
                                <a class="nav-link text-info mx-0 px-0 small" href="{{ url('riwayat-skripsi/' . $pendaftar->id_mahasiswa) }}"><span class="fa fa-info-circle"></span>&nbsp;
                                        Detail</a>
                            </li>
                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <li class="nav-item mx-0 px-0">
                                <a class="nav-link text-success mx-0 px-0 small" href="{{ url('riwayat-skripsi/'. $pendaftar->id_mahasiswa .'/edit') }}"><span class="fa fa-edit"></span>&nbsp;
                                        Edit Judul & Jurnal</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_pendaftar->onEachSide(1)->links() }}
                </nav>
@stop