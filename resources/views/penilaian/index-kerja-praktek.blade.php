@extends('template')
@section('main')
                @include('errors.form_error')

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Nilai Skripsi</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_nilai_kp as $nilai)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $nilai->jadwalUjian->mahasiswa->nama }} ({{ $nilai->jadwalUjian->mahasiswa->nim }})</p>
                                <p class="my-0 py-0">
                                    Total Nilai: {{ !empty($nilai->total) ? $nilai->total : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 
                                    Nilai Huruf: {{ !empty($nilai->nilai_huruf) ? $nilai->nilai_huruf : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 

                                    @if($nilai->status >= 'lulus')
                                        <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                    @else
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Lulus</span>
                                    @endif
                                    <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('nilai-ujian/'.$nilai->id_jadwal_ujian.'/detail') }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>    
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai->id_jadwal_ujian.'/detail') }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_nilai_kp->onEachSide(1)->links() }}
                </nav>
@stop