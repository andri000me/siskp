@extends('template-masuk')
@section('main-masuk')
            <div class="col-12 col-lg-9 my-2">

                <div class="card">
                    <h6 class="card-header bg-primary d-none d-lg-block font-weight-bold text-light"><span class="fa fa-history"></span>
                        Detail Kerja Praktek</h6>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->prodi->nama) ? $pendaftar->mahasiswa->prodi->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->angkatan) ? $pendaftar->mahasiswa->angkatan : '-' }})</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($pendaftar->mahasiswa->dosen->nama) ? $pendaftar->mahasiswa->dosen->nama : '-' }}</dd>

                            <dt>Instansi</dt>
                            <dd class="text-capitalize">{{ $pendaftar->instansi }}</dd>

                            <dt>Alamat</dt>
                            <dd class="text-capitalize">{{ $pendaftar->alamat }}</dd>

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

                            <dt>Periode Turun Kerja Praktek</dt>
                            <dd>
                                {{ !empty($pendaftar->periodeDaftarTurunKp->nama) ? $pendaftar->periodeDaftarTurunKp->nama : '-' }}
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