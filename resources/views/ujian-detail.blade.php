@extends('template-masuk')
@section('main-masuk')
            <div class="col-12 col-lg-9 my-2">

                <div class="card">
                    <h6 class="card-header bg-primary d-none d-lg-block font-weight-bold text-light"><span class="fa fa-history"></span>
                        Detail Ujian</h6>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->prodi->nama) ? $pendaftar->mahasiswa->prodi->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->angkatan) ? $pendaftar->mahasiswa->angkatan : '-' }})</dd>
                            
                            @if($pendaftar->ujian !== 'kerja-praktek')
                            <dt>Judul Skripsi</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}</dd>
                            @else
                            <dt>Instansi</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi) ? $pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi : $pendaftar->mahasiswa->dosenPembimbingKp->last()->lokasi }}</dd>

                            <dt>Alamat</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->pendaftarTurunKp->last()->alamat) ? $pendaftar->mahasiswa->pendaftarTurunKp->last()->alamat : '-' }}</dd>
                            
                            <dt>Judul Laporan</dt>
                            <dd>{{ $pendaftar->judul_laporan_kp }}</dd>

                            @endif

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->dosen->nama) ? $pendaftar->mahasiswa->dosen->nama : '-' }}</dd>

                            @if($pendaftar->ujian !== 'kerja-praktek')
                            <dt>Dosen Pembimbing Skripsi</dt>
                            <dd>
                                1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $pendaftar->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }} <br>
                            </dd>
                            @else
                            <dt>Dosen Pembimbing Kerja Praktek</dt>
                            <dd>
                                1). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ? $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                2). {{ !empty($pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ? $pendaftar->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }} <br>
                            </dd>
                            @endif

                            <dt>Ujian</dt>
                            <dd class="text-capitalize">{{ str_replace('-', ' ', $pendaftar->ujian) }}</dd>

                            <dt>Tahapan Berkas</dt>
                            <dd>
                                @if($pendaftar->tahapan === 'ditolak')
                                <span class="text-danger"> <i class="fa fa-ban"></i> Ditolak </span>
                                @elseif($pendaftar->tahapan === 'diterima')
                                <span class="text-primary"> <i class="fa fa-check"></i> Diterima </span>
                                @elseif($pendaftar->tahapan === 'diperiksa')
                                <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa </span>
                                @endif
                            </dd>

                            <dt>Periode Ujian</dt>
                            <dd>
                                {{ !empty($pendaftar->periodeDaftarUjian->nama) ? $pendaftar->periodeDaftarUjian->nama : '-' }}
                            </dd>

                            <dt>Waktu Mendaftar</dt>
                            <dd>
                                {{ selisih_waktu($pendaftar->created_at) }}
                            </dd>

                        </dl>
                    </div>

                </div>
            </div>
@stop