@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- profil -->
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Peserta Ujian</strong>

                        @if(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <a class="text-white" href="{{ url('jadwal-ujian/tambah-peserta/'. $jadwal->id) }}"><span class="fa fa-plus"></span> <span class="">Tambah</span></a>
                        @endif

                    </div>
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->nama) ? $jadwal->mahasiswa->nama : '-' }} ({{ !empty($jadwal->mahasiswa->nim) ? $jadwal->mahasiswa->nim : '-' }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->prodi->nama) ? $jadwal->mahasiswa->prodi->nama : '-' }} ({{ !empty($jadwal->mahasiswa->angkatan) ? $jadwal->mahasiswa->angkatan : '-' }})</dd>

                            <dt>Ujian</dt>
                            <dd>{{ str_replace('-', ' ', $jadwal->ujian) }}</dd>

                            <dt>Tempat</dt>
                            <dd>{{ $jadwal->tempat }}</dd>

                            <dt>Waktu</dt>
                            <dd>
                            Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA
                            </dd>
                            
                        </dl>
                    </div>
                </div>

                    <!-- daftar peserta ujian -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="jadwal">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#pesertaUjian"><span class="fa fa-history"></span> Daftar peserta Ujian </button>
                            <div id="pesertaUjian" class="collapse my-2 pb-1" data-parent="#jadwal">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <div class="table-responsive text-nowrap">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">No</th>
                                                    <th class="text-center align-middle">Nama & NIM</th>
                                                    <th class="text-center align-middle">Prodi & Angkatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1 ?>
                                                @foreach($jadwal->pesertaUjian as $peserta)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="align-middle">{{ !empty($peserta->mahasiswa->nama) ? $peserta->mahasiswa->nama : '-' }} ({{ !empty($peserta->mahasiswa->nim) ? $peserta->mahasiswa->nim : '-' }})</td>
                                                    <td class="align-middle">{{ !empty($peserta->mahasiswa->prodi->nama) ? $peserta->mahasiswa->prodi->nama : '-' }} ({{ !empty($peserta->mahasiswa->angkatan) ? $peserta->mahasiswa->angkatan : '-' }})</td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach                                    
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
@stop