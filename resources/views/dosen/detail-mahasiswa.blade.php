@extends('template')
@section('main')
<div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Detail Mahasiswa</h4>
                                    </div>

                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>

                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Nama Lengkap </td>
                                            <th>{{ $mahasiswa->nama }}</th>
                                        </tr>
                                        <tr>
                                            <td>Nomor Induk Mahasiswa</td>
                                            <th>{{ $mahasiswa->nim }}</th>
                                        </tr>
                                        <tr>
                                            <td>Program Studi</td>
                                            <th>{{ !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-' }}</th>
                                        </tr>
                                        <tr>
                                            <td>Angkatan</td>
                                            <th>{{ $mahasiswa->angkatan }}</th>
                                        </tr>
                                        <tr>
                                            <td>Dosen Pendamping Akademik</td>
                                            <th>{{ !empty($mahasiswa->dosen->nama) ? $mahasiswa->dosen->nama : '-' }}</th>
                                        </tr>
                                        @if(!empty($bisa_kp))
                                        <tr>
                                            <td>Kontrak Kerja Praktek</td>
                                            <th>
                                                @if($mahasiswa->kontrak_kp === 'ya')
                                                        <i class="fa fa-check fa-lg text-primary"></i>
                                                @else
                                                        <i class="fa fa-times fa-lg text-danger"></i>
                                                @endif
                                            </th>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Kontrak Skripsi</td>
                                            <th>
                                                @if($mahasiswa->kontrak_skripsi === 'ya')
                                                        <i class="fa fa-check fa-lg text-primary"></i>
                                                @else
                                                        <i class="fa fa-times fa-lg text-danger"></i>
                                                @endif
                                            </th>
                                        </tr>
                                        @if(!empty($bisa_kp))
                                        <tr>
                                            <td>Tahapan Kerja Praktek</td>
                                            @if($mahasiswa->tahapan_kp === 'lulus')
                                            <th class="text-primary"> 
                                                <i class="fa fa-check fa-lg"></i> &nbsp; LULUS
                                            </th>
                                            @else
                                            <th>{{ strtoupper(str_replace('_', ' ', $mahasiswa->tahapan_kp)) }}</th>
                                            @endif
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Tahapan Skripsi</td>
                                            @if($mahasiswa->tahapan_skripsi === 'lulus')
                                            <th class="text-primary"> 
                                                <i class="fa fa-check fa-lg"></i> &nbsp; LULUS
                                            </th>
                                            @else
                                            <th>{{ strtoupper(str_replace('_', ' ', $mahasiswa->tahapan_skripsi)) }}</th>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td>Dosen Pembimbing Skripsi</td>
                                            <th>
                                            @if($mahasiswa->dosenPembimbingSkripsi)
                                                @foreach($mahasiswa->dosenPembimbingSkripsi as $dosbing)
                                                    {{ !empty($dosbing->semester->nama) ? $dosbing->semester->nama : '-' }}  <br>
                                                    1). {{ !empty($dosbing->dosbingSatuSkripsi->nama) ? $dosbing->dosbingSatuSkripsi->nama : '-' }} <br>
                                                    2). {{ !empty($dosbing->dosbingDuaSkripsi->nama) ? $dosbing->dosbingDuaSkripsi->nama : '-' }} <br> <br>
                                                @endforeach
                                            @else
                                                - 
                                            @endif
                                            </th>
                                        </tr>

                                        @if(!empty($bisa_kp))
                                        <tr>
                                            <td>Dosen Pembimbing Kerja Praktek</td>
                                            <th>
                                            @if($mahasiswa->dosenPembimbingKp)
                                                @foreach($mahasiswa->dosenPembimbingKp as $dosbing)
                                                    {{ !empty($dosbing->semester->nama) ? $dosbing->semester->nama : '-' }}  <br>
                                                    1). {{ !empty($dosbing->dosbingSatuKp->nama) ? $dosbing->dosbingSatuKp->nama : '-' }} <br>
                                                    2). {{ !empty($dosbing->dosbingDuaKp->nama) ? $dosbing->dosbingDuaKp->nama : '-' }} <br> <br>
                                                @endforeach
                                            @else
                                                - 
                                            @endif
                                            </th>
                                        </tr>
                                        @endif

                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                        <!-- Riwayat Tahapan -->
                        <div class="accordion" id="accordionExample">
  
                            <!-- Riwayat Tahapan -->
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                <h2 class="m-0">
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseRiwayat">
                                    Riwayat Tahapan Skripsi dan/atau Kerja Praktek
                                    </button>
                                </h2>
                                </div>

                                <div id="collapseRiwayat" class="collapse show" data-parent="#accordionExample">
                                <div class="card-body">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>No. </th>
                                                <th>Tahapan </th>
                                                <th>Waktu</th>
                                            </tr>

                                            <?php $i=1 ?>
                                            @foreach($mahasiswa->RiwayatTahapan as $riwayat)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ strtoupper(str_replace('_', ' ', $riwayat->tahapan)) }}</td>
                                                <td>{{ $riwayat->created_at->diffForHumans() }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                </div>
                                </div>
                            </div>
  
                        </div>
                    </div>

                        <div class="col-md-12">
                        <!-- Riwayat Bimbingan -->
                        <div class="accordion" id="accordionExample">
  
                            <!-- Riwayat Bimbingan -->
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                <h2 class="m-0">
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseOne">
                                    Riwayat Bimbingan
                                    </button>
                                </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                <div class="card-body">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>No. </th>
                                                <th>Dosen </th>
                                                <th>Waktu </th>
                                                <th>Ujian </th>
                                                <th>Konsultasi </th>
                                            </tr>

                                            <?php $i=1 ?>
                                            @foreach($mahasiswa->bimbingan as $bimbingan)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $bimbingan->dosen->nama }}</td>
                                                <td>{{ $bimbingan->waktu->formatLocalized("%A, %d %B %Y") }}</td>
                                                <td>{{ strtoupper($bimbingan->bimbingan) }}</td>
                                                <td>{{ $bimbingan->konsultasi }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                </div>
                                </div>
                            </div>
  
                        </div>
                    </div>

                        @if($mahasiswa->pendaftarUsulanTopik)
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Daftar Riwayat Pendaftaran Usulan Topik</h4>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <?php $j=1 ?>
                                    @foreach($mahasiswa->pendaftarUsulanTopik as $usulan)
                                    <h4 class="my-0 py-0 pl-3"> <strong>Usulan Topik Ke-{{ $j++ }}</strong></h4>
                                    <table class="table">
                                        <tr>
                                            <td>Usulan Topik </td>
                                            <th>{{ $usulan->usulan_topik }}</th>
                                        </tr>
                                        <tr>
                                            <td>Usulan Judul </td>
                                            <th>{{ $usulan->usulan_judul }}</th>
                                        </tr>
                                        <tr>
                                            <td>Alternatif Judul </td>
                                            <th>{!! $usulan->alternatif_judul !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Permasalahan </td>
                                            <th>{!! $usulan->permasalahan !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Tujuan </td>
                                            <th>{!! $usulan->tujuan !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Manfaat </td>
                                            <th>{!! $usulan->manfaat !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Metode Penelitian </td>
                                            <th>{!! $usulan->metode_penelitian !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Metode Pengembangan Sistem </td>
                                            <th>{!! $usulan->metode_pengembangan_sistem !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Tahapan Penelitian </td>
                                            <th>{!! $usulan->tahapan_penelitian !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Periode Daftar </td>
                                            <th>{!! !empty($usulan->periodeDaftarUsulanTopik->nama) ? $usulan->periodeDaftarUsulanTopik->nama : '-' !!}</th>
                                        </tr>
                                        <tr>
                                            <td>Tahapan (Oleh Admin)</td>
                                            <th>
                                            @if($usulan->tahapan === 'diperiksa')
                                                <span class="bg-success p-1 text-light"><i class="fa fa-hourglass-half"></i> DIPERIKSA</span>
                                            @elseif($usulan->tahapan === 'diterima')
                                                <span class="bg-info p-1 text-light"><i class="fa fa-check"></i> DITERIMA</span>
                                            @elseif($usulan->tahapan === 'ditolak')
                                                <span class="bg-danger p-1 text-light"><i class="fa fa-times"></i> DITOLAK</span>
                                            @elseif($usulan->tahapan === 'dibatalkan')
                                                <span class="bg-warning p-1 text-light"><i class="fa fa-ban"></i> DIBATALKAN</span>
                                            @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Keterangan (Oleh Admin)</td>
                                            <th>{{ $usulan->keterangan }}</th>
                                        </tr>
                                    </table>
                                    <table class="table">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penulis</th>
                                            <th>Judul Artikel</th>
                                            <th>Jurnal Ilmiah</th>
                                            <th>Keterkaitan</th>
                                        </tr>
                                        <?php $i=1 ?>
                                        @foreach($usulan->referensiUtama as $referensi)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $referensi->nama_penulis }}</td>
                                            <td>{{ $referensi->judul_artikel }}</td>
                                            <td>{{ $referensi->jurnal_ilmiah }}</td>
                                            <td>{!! $referensi->keterkaitan !!}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($mahasiswa->pendaftarUjian)
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Riwayat Pendaftaran Ujian</h4>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <?php $j=1 ?>
                                    @foreach($mahasiswa->pendaftarUjian as $ujian)
                                    <h4 class="my-0 py-0 pl-3"> <strong>Pendaftaran Ujian Ke-{{ $j++ }}</strong></h4>
                                    <table class="table">
                                        <tr>
                                            <td>Ujian</td>
                                            <th>{{ strtoupper($ujian->ujian) }}</th>
                                        </tr>
                                        <tr>
                                            <td>Periode Daftar</td>
                                            <th>{{ $ujian->periodeDaftarUjian->nama }}</th>
                                        </tr>
                                        <tr>
                                            <td>Tahapan</td>
                                            <th>
                                            @if($ujian->tahapan === 'diperiksa')
                                                <span class="bg-success p-1 text-light"><i class="fa fa-hourglass-half"></i> DIPERIKSA</span>
                                            @elseif($ujian->tahapan === 'diterima')
                                                <span class="bg-info p-1 text-light"><i class="fa fa-check"></i> DITERIMA</span>
                                            @elseif($ujian->tahapan === 'ditolak')
                                                <span class="bg-danger p-1 text-light"><i class="fa fa-times"></i> DITOLAK</span>
                                            @elseif($ujian->tahapan === 'dibatalkan')
                                                <span class="bg-warning p-1 text-light"><i class="fa fa-ban"></i> DIBATALKAN</span>
                                            @endif
                                            </th>
                                        </tr>
                                    </table>
                                    <table class="table">
                                        <tr>
                                            <th>
                                                <span class="float-left">File Laporan</span>
                                                <span class="float-right"> <a href="{{ asset('assets/laporan/'.$ujian->file_laporan) }}">Download File</a> </span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="text-center embed-responsive" style="height: 75vh">
                                                <embed src="{{ asset('assets/laporan/'.$ujian->file_laporan ) }}" type="application/pdf">
                                            </td>
                                        </tr>
                                    </table>

                                    @if($ujian->hasilPlagiasi)
                                    @foreach($ujian->hasilPlagiasi as $plagiasi)
                                    <table class="table">
                                        <tr>
                                            <th>
                                            <span class="float-left">Persentasi Hasil Plagiasi</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>{{ $plagiasi->persentasi_plagiasi }}%</td>
                                        </tr>
                                    </table>

                                    <table class="table">
                                        <tr>
                                            <th>
                                                <span class="float-left">File Hasil Plagiasi Laporan</span>
                                                <span class="float-right"> <a href="{{ asset('assets/plagiasi/'.$plagiasi->file_hasil_plagiasi) }}">Download File</a> </span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="text-center embed-responsive" style="height: 75vh">
                                                <embed src="{{ asset('assets/plagiasi/'.$plagiasi->file_hasil_plagiasi ) }}" type="application/pdf">
                                            </td>
                                        </tr>
                                    </table>
                                    @endforeach
                                    @endif

                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($mahasiswa->jadwalUjian)
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Riwayat Jadwal Ujian</h4>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>TEMPAT & WAKTU</th>
                                            <th>UJIAN</th>
                                            <th>DOSEN PENGUJI</th>
                                            <th>PESERTA UJIAN</th>
                                        </tr>
                                        @foreach($mahasiswa->jadwalUjian as $jadwal)
                                            <tr>
                                            <td>{{ $jadwal->tempat }}, {{ $jadwal->waktu_mulai->formatLocalized("%A, %d %B %Y") }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
                                            <td>{{ strtoupper($jadwal->ujian) }}</td>
                                            <td>
                                                @foreach($jadwal->dosenPenguji as $penguji)
                                                    {{ $penguji->dospeng }}. {{ $penguji->dosen->nama }} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <?php $k=1 ?>
                                                @foreach($jadwal->pesertaUjian as $peserta)
                                                    {{ $k++ }}. {{ $peserta->mahasiswa->nama }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif                        

                    </div>
                </div>
            </div>
@stop