@extends('template')
@section('main')
                <!-- jadwal ujian bulan ini -->
                <p class="mb-2">Total Data: <strong>{{ $total }}</strong><br></p>

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span
                            class="far fa-clock"></span> Jadwal Ujian 
                        @switch($bulan)
                            @case(1) Januari @break
                            @case(2) Februari @break
                            @case(3) Maret @break
                            @case(4) April @break
                            @case(5) Mei @break
                            @case(6) Juni @break
                            @case(7) Juli @break
                            @case(8) Agustus @break
                            @case(9) September @break
                            @case(10) Oktober @break
                            @case(11) November @break
                            @case(12) Desember @break
                        @endswitch 
                            {{ $tahun }} </h6>
                    
                    <!-- jika data ada -->
                    @if(!blank($daftar_jadwal_bulan_ini))
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">Nama & NIM</th>
                                        <th class="text-center align-middle">Ujian</th>
                                        <th class="text-center align-middle">Tempat & Waktu</th>
                                        <th class="text-center align-middle">Dosen Penguji</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach($daftar_jadwal_bulan_ini as $jadwal)
                                    <tr>
                                        <td class="text-center align-middle">{{ $i }}</td>
                                        <td class="align-middle">{{ $jadwal->mahasiswa->nama }} <br> {{ $jadwal->mahasiswa->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                        <td class="align-middle">
                                            {{ $jadwal->tempat }} <br> Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA
                                        </td>
                                        <td class="align-middle">
                                            @foreach($jadwal->dosenPenguji as $penguji)
                                                {{ $penguji->dospeng }}). {{ $penguji->dosen->nama }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                    @else
                    <!-- jika data kosong -->
                    <div class="card-body border-bottom">
                        <h6 class="card-title text-center"> <span class="fa fa-info-circle"></span> Belum ada data</h6>
                    </div>
                    @endif
                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_jadwal_bulan_ini->onEachSide(1)->links() }}
                </nav>

                <!-- jadwal ujian saya -->
                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span class="far fa-clock"></span> Daftar Jadwal Ujian Saya</h6>
                    
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">Ujian</th>
                                        <th class="text-center align-middle">Tempat & Waktu</th>
                                        <th class="text-center align-middle">Dosen Penguji</th>
                                        <th class="text-center align-middle">Peserta Ujian</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach($daftar_jadwal as $jadwal)
                                    <tr>
                                        <td class="text-center align-middle">{{ $i }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                        <td class="align-middle">
                                            {{ $jadwal->tempat }} <br> Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA
                                        </td>
                                        <td class="align-middle">
                                            @foreach($jadwal->dosenPenguji as $penguji)
                                                {{ $penguji->dospeng }}). {{ $penguji->dosen->nama }} <br>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">
                                            <?php $j=1 ?>
                                                @foreach($jadwal->pesertaUjian as $peserta)
                                                    {{ $j++ }}. {{ $peserta->mahasiswa->nama }} ({{ $peserta->mahasiswa->nim }}) <br>
                                                @endforeach
                                        </td>
                                        <td class="text-center align-middle">
                                            <a class="text-dark text-center small d-none d-lg-block" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}"><span class="fa fa-bars fa-lg"></span></a>
                                            
                                            <a class="text-dark text-center small d-lg-none" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}"><span class="fa fa-bars fa-lg"></span></a>
                                        </td>
                                    </tr>

                                    <?php $i++ ?>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                    
                </div>

                        <?php $i=1 ?>
                        @foreach($daftar_jadwal as $jadwal)

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$jadwal->id.'/detail') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Ujian</a></p>
                                            
                                            @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil' || $jadwal->ujian === 'sidang-skripsi')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/administrasi-ujian/'. $jadwal->id ) }}"><i class="fa fa-download"></i> Unduh administrasi ujian</a></p>
                                            @elseif($jadwal->ujian === 'kerja-praktek')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-administrasi-ujian-kp/'. $jadwal->id ) }}"><i class="fa fa-download"></i> Unduh administrasi ujian</a></p>
                                            @endif

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$jadwal->id.'/detail') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Ujian</a></p>
                                            
                                            @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil' || $jadwal->ujian === 'sidang-skripsi')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/administrasi-ujian/'. $jadwal->id ) }}"><i class="fa fa-download"></i> Unduh administrasi ujian</a></p>
                                            @elseif($jadwal->ujian === 'kerja-praktek')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-administrasi-ujian-kp/'. $jadwal->id ) }}"><i class="fa fa-download"></i> Unduh administrasi ujian</a></p>
                                            @endif

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php $i++ ?>
                        @endforeach

@stop