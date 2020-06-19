@extends('template-masuk')
@section('main-masuk')
            <div class="col-12 col-lg-9 my-2">

                <div class="card">
                    <h6 class="card-header bg-primary d-none d-lg-block font-weight-bold text-light"><span class="fa fa-history"></span>
                        Detail Usulan Topik</h6>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->prodi->nama) ? $pendaftar->mahasiswa->prodi->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->angkatan) ? $pendaftar->mahasiswa->angkatan : '-' }})</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->dosen->nama) ? $pendaftar->mahasiswa->dosen->nama : '-' }}</dd>

                            <dt>Usulan Topik</dt>
                            <dd>{{ $pendaftar->usulan_topik }}</dd>

                            <dt>Usulan Judul</dt>
                            <dd>{{ $pendaftar->usulan_judul }}</dd>

                            <dt>Alternatif Judul</dt>
                            <dd>{!! $pendaftar->alternatif_judul !!}</dd>

                            <dt>Permasalahan</dt>
                            <dd>{!! $pendaftar->permasalahan !!}</dd>

                            <dt>Tujuan</dt>
                            <dd>{!! $pendaftar->tujuan !!}</dd>

                            <dt>Manfaat</dt>
                            <dd>{!! $pendaftar->manfaat !!}</dd>

                            <dt>Metode Penelitian</dt>
                            <dd>{!! $pendaftar->metode_penelitian !!}</dd>

                            <dt>Metode Pengembangan Sistem</dt>
                            <dd>{!! $pendaftar->metode_pengembangan_sistem !!}</dd>

                            <dt>Tahapan Penelitian</dt>
                            <dd>{!! $pendaftar->tahapan_penelitian !!}</dd>

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

                            <dt>Periode Usulan Topik</dt>
                            <dd>
                                {{ $pendaftar->periodeDaftarUsulanTopik->nama }}
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