@extends('template')
@section('main')
                @include('errors.form_error')
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3 d-block">
                        <!-- validasi pendaftar -->
                        <div class="accordion mb-2 d-block" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-check"></span> Validasi Berkas Ujian </button>
                            
                            <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'validasi/ujian']) !!}
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

                    <div class="col-12 col-lg-6 mb-3">
                        <!-- upload plagiasi -->
                        <div class="accordion mb-2 d-block" id="filter">
                            <button class="btn btn-outline-primary btn-block btn-sm" type="button" data-toggle="collapse" data-target="#plagiasi"><span class="fa fa-upload"></span> Upload Plagiasi Laporan </button>
                            
                            <div id="plagiasi" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('pendaftaran/ujian/upload-plagiasi') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id_pendaftar_ujian', $pendaftar->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Persentase Plagiasi (%)</label>
                                            @if($plagiasi)
                                                <h5>{{ $plagiasi->persentasi_plagiasi }}%</h5>
                                            @else
                                                {!! Form::text('persentasi_plagiasi', null, ['class' => 'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label> File Hasil Plagiasi (Bertipe pdf & Ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb)</label>
                                            @if($plagiasi)
                                                <h6> <a target="_blank" href="{{ asset('assets/plagiasi/'.$plagiasi->file_hasil_plagiasi) }}">{{ $plagiasi->file_hasil_plagiasi }}</a> </h6>
                                            @else
                                                <div class="custom-file">
                                                    <label class="custom-file-label" id="targetSatu"> Pilih File Plagiasi</label>
                                                    {!! Form::file('file_hasil_plagiasi', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="form-row">
                                        <div class="col-12">
                                        @if($plagiasi)
                                            <a href="#" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalPlagiasi" rel="tooltip" title="Hapus"><i class="fa fa-trash fa-lg"></i> Hapus Plagiasi</a>
                                        @else
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button>
                                        @endif
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
                        <strong class="bg-primary text-light">Detail Pendaftar Ujian</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->prodi->nama) ? $pendaftar->mahasiswa->prodi->nama : '-' }} ({{ $pendaftar->mahasiswa->angkatan }})</dd>

                            <dt>Ujian</dt>
                            <dd>{{ ucwords(str_replace('-', ' ', $pendaftar->ujian)) }}</dd>

                            <dt>Periode Ujian</dt>
                            <dd>{{ !empty($pendaftar->periodeDaftarUjian->nama) ? $pendaftar->periodeDaftarUjian->nama : '-' }}</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->dosen->nama) ? $pendaftar->mahasiswa->dosen->nama : '-' }}</dd>

                        @if($pendaftar->ujian !== 'kerja-praktek')
                            <dt>Judul Skripsi</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}</dd>

                            <dt>Dosen Pembimbing Skripsi</dt>
                            <dd>
                                1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-'}} <br>
                            </dd>
                        @else
                            <dt>Judul Laporan</dt>
                            <dd>{{ !empty($pendaftar->judul_laporan_kp) ? $pendaftar->judul_laporan_kp : '-' }}</dd>

                            <dt>Instansi</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi) ? $pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi : $pendaftar->mahasiswa->dosenPembimbingKp->last()->lokasi }}</dd>

                            <dt>Alamat Instansi</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarTurunKp->last()->alamat) ? $pendaftar->mahasiswa->pendaftarTurunKp->last()->alamat : '-' }}</dd>

                            <dt>Dosen Pembimbing Kerja Praktek</dt>
                            <dd>
                                1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ? $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ? $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }} <br>
                            </dd>
                        @endif

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
                            
                            <dt>Keterangan Validasi (dari Admin)</dt>
                            <dd class="text-dark">{{ $pendaftar->keterangan }}</dd>

                        @if($pengaturan->skor_sertifikat_toefl !== 'hilangkan' && $pendaftar->ujian === 'sidang-skripsi')
                            <dt>Skor TOEFL</dt>
                            <dd class="text-dark">{{ $pendaftar->skor_toefl }}</dd>

                            <!-- file sertifikat toefl -->
                            <dt>File Sertifikat TOEFL 
                                @if(isset($pendaftar->file_sertifikat_toefl))
                            <small><a href="{{ asset('assets/sertifikat-toefl/'.$pendaftar->file_sertifikat_toefl) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika file ada -->
                            @if(isset($pendaftar->file_sertifikat_toefl))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/sertifikat-toefl/'.$pendaftar->file_sertifikat_toefl) }}" type="application/pdf">
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif
                        @endif
                        
                        @if($pengaturan->file_laporan !== 'hilangkan')
                            <!-- file laporan -->
                            <dt>File Laporan 
                                @if(isset($pendaftar->file_laporan))
                            <small><a href="{{ asset('assets/laporan/'.$pendaftar->file_laporan) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika file ada -->
                            @if(isset($pendaftar->file_laporan))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/laporan/'.$pendaftar->file_laporan) }}" type="application/pdf">
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif
                        @endif

                        @if($pengaturan->persetujuan_ujian !== 'hilangkan')
                            <!-- file lembar persetujuan -->
                            <dt>File Scan Lembar Persetujuan 
                                @if(isset($pendaftar->file_lembar_persetujuan))
                            <small><a href="{{ asset('assets/persetujuan-ujian/' . $pendaftar->file_lembar_persetujuan) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika file ada -->
                            @if(isset($pendaftar->file_lembar_persetujuan))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/persetujuan-ujian/' . $pendaftar->file_lembar_persetujuan) }}" type="application/pdf">
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif
                        @endif

                        @if($plagiasi)
                            <!-- persentase plagiasi -->
                            <dt>Persentase Plagiasi</dt>
                            <dd>{{ $plagiasi->persentasi_plagiasi }}%</dd>

                            <!-- file hasil plagiasi -->
                            <dt>File Hasil Plagiasi 
                                @if(isset($plagiasi->file_hasil_plagiasi))
                            <small><a href="{{ asset('assets/plagiasi/'.$plagiasi->file_hasil_plagiasi) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika file ada -->
                            @if(isset($plagiasi->file_hasil_plagiasi))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/plagiasi/'.$plagiasi->file_hasil_plagiasi) }}" type="application/pdf">
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif
                        
                            <!-- modal hapus -->
                            <div class="modal fade" id="modalPlagiasi" tabindex="-1">
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
                                            {!! Form::open(['url' => 'pendaftaran/ujian/upload-plagiasi/'.$plagiasi->id , 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                            <dt>Waktu Daftar</dt>
                            <dd>{{ selisih_waktu($pendaftar->created_at) }}</dd>
                        </dl>
                    </div>

                </div>
            
@stop