@extends('template')
@section('main')

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light">Semua Jadwal Ujian</h6>
                    
                    <?php $i=1 ?>
                    @foreach($daftar_jadwal as $jadwal)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0 text-capitalize">{{ $i }}). 
                                @switch($jadwal->bulan)
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
                                {{ $jadwal->tahun }}
                                </p>
                                <p class="my-0 py-0 text-dark">
                                    {{ $jadwal->total }} Mahasiswa 
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-primary mx-0 px-0 small" href="{{ url('jadwal-ujian/'.$jadwal->tahun.'-'.$jadwal->bulan) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('jadwal-ujian/'.$jadwal->tahun.'-'.$jadwal->bulan) }}">
                                    <span class="fa fa-info-circle fa-lg"></span>&nbsp; Detail
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                    
                </div>

@stop