@extends('template')
@section('main')

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light">Jadwal Menguji 
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
                    @if(!blank($daftar_pengujian))
                    <?php $i=1 ?>
                    @foreach($daftar_pengujian as $pengujian)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0 text-capitalize">{{ $i }}). {{ $pengujian->jadwalUjian->mahasiswa->nama }} ({{ $pengujian->jadwalUjian->mahasiswa->nim }})</p>
                                <p class="my-0 py-0 text-dark">
                                    Ujian <span class="text-capitalize">{{ str_replace('-', ' ', $pengujian->jadwalUjian->ujian) }}</span><br>
                                    {{ $pengujian->jadwalUjian->tempat }} <br> Hari {{ tanggal($pengujian->jadwalUjian->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($pengujian->jadwalUjian->waktu_mulai)) }} - {{ date('H:i', strtotime($pengujian->jadwalUjian->waktu_selesai)) }} WITA <br>
                                    Penguji: {{ $pengujian->dospeng }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-primary mx-0 px-0 small" href="{{ url('nilai-ujian/'. $pengujian->id_jadwal_ujian .'/detail') }}"><span class="fa fa-check-double"></span>&nbsp; Detail Nilai</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/'. $pengujian->id_jadwal_ujian .'/detail') }}">Detail Nilai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                    @else
                    <!-- jika data kosong -->
                    <div class="card-body border-bottom">
                        <h6 class="card-title text-center"> <span class="fa fa-info-circle"></span> Belum ada data</h6>
                    </div>
                    @endif
                </div>

@stop