@extends('template-masuk')
@section('main-masuk')
            <div class="col-12 col-lg-9 my-2">

                <div class="card">
                    <h6 class="card-header bg-primary d-none d-lg-block font-weight-bold text-light"><span class="fa fa-history"></span>
                        Detail Riwayat Skripsi</h6>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-' }} ({{ $mahasiswa->angkatan }})</dd>

                            <dt>Judul Skripsi</dt>
                            <dd>
                            {{ !empty($mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}
                            </dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($mahasiswa->dosen->nama) ? $mahasiswa->dosen->nama : '-' }}</dd>

                            <dt>Dosen Pembimbing Skripsi</dt>
                            <dd>
                                1). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                2). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }} <br>
                            </dd>

                            <dt>Tahapan Skripsi</dt>
                            @if($mahasiswa->tahapan_skripsi === 'lulus')
                            <dd class="text-primary text-capitalize"> <i class="fa fa-check"></i> {{ str_replace('_', ' ', $mahasiswa->tahapan_skripsi) }} </dd>
                            @else
                            <dd class="text-dark text-capitalize"> <i class="fa fa-hourglass-half"></i> {{ str_replace('_', ' ', $mahasiswa->tahapan_skripsi) }}</dd>
                            @endif

                            <dt>File Jurnal Skripsi 
                                @if(isset($mahasiswa->riwayatSkripsi->last()->file_jurnal_skripsi))
                            <small><a href="{{ asset('assets/jurnal/' . $mahasiswa->riwayatSkripsi->last()->file_jurnal_skripsi) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika jurnal ada -->
                            @if(isset($mahasiswa->riwayatSkripsi->last()->file_jurnal_skripsi))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/jurnal/' . $mahasiswa->riwayatSkripsi->last()->file_jurnal_skripsi) }}" type="application/pdf">
                            </dd>
                            <!-- jika jurnal kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif                            
                        </dl>
                    </div>

                </div>
                
            </div>
@stop