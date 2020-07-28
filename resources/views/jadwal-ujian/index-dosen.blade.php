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
                                        <th class="text-center align-middle">Judul</th>
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
                                        <td class="text-left align-middle">
                                        @if($jadwal->ujian !== 'kerja-praktek')
                                            {!! Str::title(wordwrap($jadwal->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul, 40, "<br>", true)) !!}
                                        @else
                                            {!! !empty((Str::title(wordwrap($jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null; })->last()->judul_laporan_kp, 40, "<br>", true)))) ? Str::title(wordwrap($jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null;})->last()->judul_laporan_kp, 40, "<br>", true)) : Str::title(wordwrap($jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null;})->first()->judul_laporan_kp, 40, "<br>", true)) !!}
                                        @endif
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
                
@stop