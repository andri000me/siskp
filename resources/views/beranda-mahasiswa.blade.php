@extends('template')
@section('main')

            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                    @if(Session::has('bisa_kp'))
                        <!-- TAHAPAN SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                    Tahapan Skripsi Anda
                                </h5>
                                <div class="card-body">
                                    @if($mahasiswa->tahapan_skripsi === 'persiapan') 
                                        <h5 class="mt-0 pt-0">1). Persiapan!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 11 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_topik') 
                                        <h5 class="mt-0 pt-0">2). Pendaftaran Usulan Topik!</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Tersisa 10 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'penyusunan_proposal') 
                                        <h5 class="mt-0 pt-0">3). Penyusunan Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 9 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_proposal') 
                                        <h5 class="mt-0 pt-0">4). Pendaftaran Ujian Seminar Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 8 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_seminar_proposal') 
                                        <h5 class="mt-0 pt-0">5). Ujian Seminar Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 7 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'penulisan_skripsi') 
                                        <h5 class="mt-0 pt-0">6). Penulisan Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 6 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_hasil') 
                                        <h5 class="mt-0 pt-0">7). Pendaftaran Ujian Seminar Hasil!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 5 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_seminar_hasil') 
                                        <h5 class="mt-0 pt-0">8). Ujian Seminar Hasil!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 4 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'revisi_skripsi') 
                                        <h5 class="mt-0 pt-0">9). Revisi Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 3 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_sidang_skripsi') 
                                        <h5 class="mt-0 pt-0">10). Pendaftaran Ujian Sidang Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 2 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_sidang_skripsi') 
                                        <h5 class="mt-0 pt-0">11). Ujian Sidang Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 1 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'lulus') 
                                        <h5 class="mt-0 pt-0">12). Lulus!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Selamat Atas Kelulusannya!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- TAHAPAN KERJA PRAKTEK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                    Tahapan Kerja Praktek Anda
                                </h5>
                                <div class="card-body mx-1">
                                    @if($mahasiswa->tahapan_kp === 'persiapan') 
                                        <h5 class="mt-0 pt-0">1). Persiapan!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 4 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_kp === 'pendaftaran') 
                                        <h5 class="mt-0 pt-0">2). Pendaftaran Ujian Seminar Kerja Praktek!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 3 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_kp === 'ujian_seminar') 
                                        <h5 class="mt-0 pt-0"> 3). Ujian Seminar Kerja Praktek!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Tersisa 2 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_kp === 'revisi') 
                                        <h5 class="mt-0 pt-0">4). Revisi!</h5>
                                        <hr class="my-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 1 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_kp === 'lulus') 
                                        <h5 class="mt-0 pt-0">5). Lulus!</h5>
                                        <hr class="my-0 pt-0">
                                        <h6 class="mt-0 pt-0">Selamat Atas Kelulusannya!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- KONTRAK SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                    Kontrak Skripsi
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if($mahasiswa->kontrak_skripsi === 'ya') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-primary"> <i class="fa fa-check"></i> Ya</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Anda Mengontrak Mata Kuliah Skripsi!</h6>
                                    @elseif($mahasiswa->kontrak_skripsi === 'tidak') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Tidak</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Hubungi Admin Sistem Jika Anda Mengontrak Mata Kuliah Skripsi!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- KONTRAK KERJA PRAKTEK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                        Kontrak Kerja Praktek
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if($mahasiswa->kontrak_kp === 'ya') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-primary"> <i class="fa fa-check"></i> Ya</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Anda Mengontrak Mata Kuliah Kerja Praktek!</h6>
                                    @elseif($mahasiswa->kontrak_kp === 'tidak') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Tidak</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Hubungi Admin Sistem Jika Anda Mengontrak Mata Kuliah Kerja Praktek!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- DOSEN PENDAMPING AKADEMIK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header text-light bg-primary">
                                        Dosen Pendamping Akademik
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if($mahasiswa->id_dosen) 
                                        <h5 class="mt-0 pt-0">{{ $mahasiswa->dosen->nama }}</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pendamping Akademik Bisa Mengawasi Progress Skripsi dan Kerja Praktek Anda!</h6>
                                    @else
                                        <h5 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Silahkan Masukan Dosen Pendamping Akademik!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- DOSEN PEMBIMBING SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                        Dosen Pembimbing Skripsi
                                </h5>
                                <div class="card-body">
                                    @if(!blank($mahasiswa->dosenPembimbingSkripsi)) 
                                        <h5 class="mt-0 pt-0">
                                        1). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                        2). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }}
                                        </h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Skripsi Bisa Mengawasi Progress Skripsi Anda!</h6>
                                    @else
                                        <h5 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Skripsi Anda Belum Dimasukan Oleh Admin Sistem!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- DOSEN PEMBIMBING KERJA PRAKTEK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                        Dosen Pembimbing Kerja Praktek
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if(!blank($mahasiswa->dosenPembimbingKp)) 
                                        <h5 class="mt-0 pt-0">
                                        1). {{ !empty($mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ? $mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                        2). {{ !empty($mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ? $mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }}
                                        </h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Kerja Praktek Bisa Mengawasi Progress Kerja Praktek Anda!</h6>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Kerja Praktek Anda Belum Dimasukan Oleh Admin Sistem!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- PROGRES BIMBINGAN -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Progres Bimbingan
                                    </div>
                                </h5>
                                <div class="card-body border">
                                    <table class="table table-striped table-bordered table-sm">
                                        <tr>
                                            <th>Proposal</th>
                                            <td>{{ $bimbingan_proposal }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Hasil</th>
                                            <td>{{ $bimbingan_hasil }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Sidang Skripsi</th>
                                            <td>{{ $bimbingan_sidang }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Kerja Praktek</th>
                                            <td>{{ $bimbingan_kp }} Kali</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <!-- JADWAL UJIAN -->
                        <div class="col-12 col-lg-8 mb-2 px-0 pr-lg-1">
                            <div class="card">
                                <h5 class="card-header text-light bg-primary">
                                        Jadwal Ujian
                                </h5>
                                <div class="card-body table-full-width table-responsive text-nowrap">
                                    @if(!$jadwal_ujian->isEmpty()) 
                                        <table class="table table-striped table-sm">
                                            <tr>
                                                <th>Ujian</th>
                                                <th>Tempat</th>
                                                <th>Waktu</th>
                                            </tr>
                                            @foreach($jadwal_ujian as $jadwal)
                                                <tr>
                                                    <td class="text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                                    <td>{{ $jadwal->tempat }}</td>
                                                    <td>{{ tanggal($jadwal->waktu_mulai) }} Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- PESERTA UJIAN -->
                        <div class="col-12 col-lg-4 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Peserta Ujian
                                </h5>
                                <div class="card-body">
                                        <h5 class="mt-0 pt-0">{{ $peserta_ujian }} Kali</h5>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <div class="row">
                        <!-- NILAI SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Nilai Ujian Skripsi
                                </h5>
                                <div class="card-body border table-full-width table-responsive text-nowrap">
                                    @if(!$nilai_skripsi->isEmpty()) 
                                        <table class="table table-hover table-striped table-sm">
                                        <thead>
                                            <th>Seminar Proposal</th>
                                            <th>Seminar Hasil</th>
                                            <th>Sidang Skripsi</th>
                                            <th>Total Nilai</th>
                                            <th>Huruf</th>
                                        </thead>
                                        <tbody>
                                            @foreach($nilai_skripsi as $nilai)
                                            <tr>
                                                <td>{{ $nilai->seminar_proposal }} </td>
                                                <td>{{ $nilai->seminar_hasil }}</td>
                                                <td>{{ $nilai->sidang_skripsi }}</td>
                                                <td>{{ $nilai->total }}</td>
                                                <td>{{ $nilai->nilai_huruf }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- NILAI KERJA PRAKTEK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Nilai Ujian Kerja Praktek
                                </h5>
                                <div class="card-body table-full-width table-responsive text-nowrap">
                                    @if(!$nilai_kp->isEmpty()) 
                                        <table class="table table-hover table-striped table-sm">
                                        <thead>
                                            <th>Total Nilai</th>
                                            <th>Huruf</th>
                                        </thead>
                                        <tbody>
                                            @foreach($nilai_kp as $nilai)
                                            <tr>
                                                <td>{{ $nilai->total }}</td>
                                                <td>{{ $nilai->nilai_huruf }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                        <!-- TAHAPAN SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                    Tahapan Skripsi Anda
                                </h5>
                                <div class="card-body mx-1">
                                    @if($mahasiswa->tahapan_skripsi === 'persiapan') 
                                        <h5 class="mt-0 pt-0">1). Persiapan!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 11 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_topik') 
                                        <h5 class="mt-0 pt-0">2). Pendaftaran Usulan Topik!</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Tersisa 10 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'penyusunan_proposal') 
                                        <h5 class="mt-0 pt-0">3). Penyusunan Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 9 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_proposal') 
                                        <h5 class="mt-0 pt-0">4). Pendaftaran Ujian Seminar Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 8 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_seminar_proposal') 
                                        <h5 class="mt-0 pt-0">5). Ujian Seminar Proposal!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 7 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'penulisan_skripsi') 
                                        <h5 class="mt-0 pt-0">6). Penulisan Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 6 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_hasil') 
                                        <h5 class="mt-0 pt-0">7). Pendaftaran Ujian Seminar Hasil!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 5 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_seminar_hasil') 
                                        <h5 class="mt-0 pt-0">8). Ujian Seminar Hasil!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 4 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'revisi_skripsi') 
                                        <h5 class="mt-0 pt-0">9). Revisi Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 3 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'pendaftaran_sidang_skripsi') 
                                        <h5 class="mt-0 pt-0">10). Pendaftaran Ujian Sidang Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 2 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'ujian_sidang_skripsi') 
                                        <h5 class="mt-0 pt-0">11). Ujian Sidang Skripsi!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0">Tersisa 1 Tahapan lagi!</h6>
                                    @elseif($mahasiswa->tahapan_skripsi === 'lulus') 
                                        <h5 class="mt-0 pt-0">12). Lulus!</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Selamat Atas Kelulusannya!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- DOSEN PENDAMPING AKADEMIK -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header text-light bg-primary">
                                        Dosen Pendamping Akademik
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if($mahasiswa->id_dosen) 
                                        <h5 class="mt-0 pt-0">{{ $mahasiswa->dosen->nama }}</h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pendamping Akademik Bisa Mengawasi Progress Skripsi dan Kerja Praktek Anda!</h6>
                                    @else
                                        <h5 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Silahkan Masukan Dosen Pendamping Akademik!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- KONTRAK SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                    Kontrak Skripsi
                                </h5>
                                <div class="card-body table-full-width table-responsive mx-1">
                                    @if($mahasiswa->kontrak_skripsi === 'ya') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-primary"> <i class="fa fa-check"></i> Ya</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Anda Mengontrak Mata Kuliah Skripsi!</h6>
                                    @elseif($mahasiswa->kontrak_skripsi === 'tidak') 
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Tidak</span></h4>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Hubungi Admin Sistem Jika Anda Mengontrak Mata Kuliah Skripsi!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- PROGRES BIMBINGAN -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Progres Bimbingan
                                    </div>
                                </h5>
                                <div class="card-body border">
                                    <table class="table table-striped table-bordered table-sm">
                                        <tr>
                                            <th>Proposal</th>
                                            <td>{{ $bimbingan_proposal }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Hasil</th>
                                            <td>{{ $bimbingan_hasil }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Sidang Skripsi</th>
                                            <td>{{ $bimbingan_sidang }} Kali</td>
                                        </tr>
                                        <tr>
                                            <th>Kerja Praktek</th>
                                            <td>{{ $bimbingan_kp }} Kali</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <!-- DOSEN PEMBIMBING SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pr-lg-1">
                            <div class="card strpied-tabled-with-hover">
                                <h5 class="card-header bg-primary text-light">
                                        Dosen Pembimbing Skripsi
                                </h5>
                                <div class="card-body">
                                @if(!blank($mahasiswa->dosenPembimbingSkripsi)) 
                                        <h5 class="mt-0 pt-0">
                                        1). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                        2). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }}
                                        </h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Skripsi Bisa Mengawasi Progress Skripsi Anda!</h6>
                                    @else
                                        <h5 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h5>
                                        <hr class="mt-0 pt-0">
                                        <h6 class="mt-0 pt-0"> Dosen Pembimbing Skripsi Anda Belum Dimasukan Oleh Admin Sistem!</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- NILAI SKRIPSI -->
                        <div class="col-12 col-lg-6 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Nilai Ujian Skripsi
                                </h5>
                                <div class="card-body border table-full-width table-responsive">
                                    @if(!$nilai_skripsi->isEmpty()) 
                                        <table class="table table-hover table-striped table-sm">
                                        <thead>
                                            <th>Seminar Proposal</th>
                                            <th>Seminar Hasil</th>
                                            <th>Sidang Skripsi</th>
                                            <th>Total Nilai</th>
                                            <th>Huruf</th>
                                        </thead>
                                        <tbody>
                                            @foreach($nilai_skripsi as $nilai)
                                            <tr>
                                                <td>{{ $nilai->seminar_proposal }} </td>
                                                <td>{{ $nilai->seminar_hasil }}</td>
                                                <td>{{ $nilai->sidang_skripsi }}</td>
                                                <td>{{ $nilai->total }}</td>
                                                <td>{{ $nilai->nilai_huruf }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- JADWAL UJIAN -->
                        <div class="col-12 col-lg-8 mb-2 px-0 pr-lg-1">
                            <div class="card">
                                <h5 class="card-header text-light bg-primary">
                                        Jadwal Ujian
                                </h5>
                                <div class="card-body table-full-width table-responsive text-nowrap">
                                    @if(!$jadwal_ujian->isEmpty()) 
                                        <table class="table table-striped table-sm">
                                            <tr>
                                                <th>Ujian</th>
                                                <th>Tempat</th>
                                                <th>Waktu</th>
                                            </tr>
                                            @foreach($jadwal_ujian as $jadwal)
                                                <tr>
                                                    <td class="text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                                    <td>{{ $jadwal->tempat }}</td>
                                                    <td>{{ tanggal($jadwal->waktu_mulai) }} Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        <h4 class="mt-0 pt-0"> <span class="badge badge-danger"><i class="fa fa-times"></i> Belum Ada Data</span></h4>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- PESERTA UJIAN -->
                        <div class="col-12 col-lg-4 mb-2 px-0 pl-lg-1">
                            <div class="card">
                                <h5 class="card-header bg-primary text-light">
                                        Peserta Ujian
                                </h5>
                                <div class="card-body">
                                        <h5 class="mt-0 pt-0">{{ $peserta_ujian }} Kali</h5>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    @endif

                    @if(empty($revisi) && $mahasiswa->tahapan_skripsi === 'lulus')
                        <div class="modal fade" id="modalInfo" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-light">
                                        <h5 class="modal-title"> <i class="fa fa-info-circle"></i> Info Revisi</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body text-dark h6">
                                        Setelah ujian sidang skripsi anda harus memasukan laporan & jurnal skripsi yang sudah direvisi!
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-primary btn-sm" href="{{ url('revisi-skripsi/create') }}"> <i class="fa fa-upload"></i> Masukan</a>
                                        <button type="button" class="btn btn-link btn-danger btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    </div>
                </div>
            </div>
@stop