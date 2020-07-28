@extends('template')
@section('main')
                @include('errors.form_error')
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <div class="row">
                    <div class="col-12 col-lg-12 mb-3">
                        <!-- validasi pendaftar -->
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-check"></span> Validasi Berkas Turun Kerja Praktek </button>
                            
                            <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'validasi/turun-kp']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $pendaftar->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Tahapan</label>
                                            {!! Form::select('tahapan', ['diperiksa' => 'Diperiksa', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'], $pendaftar->tahapan, ['class' => 'custom-select']) !!}
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Keterangan</label>
                                            {!! Form::textarea('keterangan', $pendaftar->keterangan, ['class' => 'form-control', 'style' => 'height:100px']) !!}
                                        </div>
                                    </div>
                                
                                    <div class="form-row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>                    
                    </div>

                </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Pendaftar Turun Kerja Praktek</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-'}} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->prodi->nama) ? $pendaftar->mahasiswa->prodi->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->angkatan) ? $pendaftar->mahasiswa->angkatan : '-' }})</dd>

                            <dt>Instansi</dt>
                            <dd>{{ $pendaftar->instansi }}</dd>

                            <dt>Alamat</dt>
                            <dd>{{ $pendaftar->alamat }}</dd>

                            <dt>Periode Turun Kerja Praktek</dt>
                            <dd>{{ !empty($pendaftar->periodeDaftarTurunKp->nama) ? $pendaftar->periodeDaftarTurunKp->nama : '-' }}</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->dosen->nama) ? $pendaftar->mahasiswa->dosen->nama : '-' }}</dd>
                        
                            <dt>Tahapan Berkas (dari Admin)</dt>
                            @if($pendaftar->tahapan === 'diperiksa')
                            <dd class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> Diperiksa</dd>
                            @elseif($pendaftar->tahapan === 'diterima')
                            <dd class="text-info text-capitalize"><i class="fa fa-check"></i> Diterima</dd>
                            @elseif($pendaftar->tahapan === 'ditolak')
                            <dd class="text-danger text-capitalize"><i class="fa fa-times"></i> Ditolak</dd>
                            @elseif($pendaftar->tahapan === 'dibatalkan')
                            <span class="text-danger text-capitalize"><i class="fa fa-ban"></i> Dibatalkan</span>
                            @endif
                            
                            <dt>Keterangan Validasi (dari Admin) </dt>
                            <dd class="text-dark">{{ $pendaftar->keterangan }}</dd>

                        @if($pengaturan->scan_persetujuan_kantor !== 'hilangkan')
                            <!-- file laporan -->
                            <dt>File Lembar Persetujuan 
                                @if(isset($pendaftar->file_lembar_persetujuan))
                            <small><a href="{{ asset('assets/persetujuan-kp/'.$pendaftar->file_lembar_persetujuan) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika file ada -->
                            @if(isset($pendaftar->file_lembar_persetujuan))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/persetujuan-kp/'.$pendaftar->file_lembar_persetujuan) }}" type="application/pdf">
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif
                        @endif
                        
                            <dt>Waktu Daftar</dt>
                            <dd>{{ selisih_waktu($pendaftar->created_at) }}</dd>                       
                        </dl>
                    </div>

                </div>
            
@stop