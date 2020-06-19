@extends('template')
@section('main')
                @include('errors.form_error')
                
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Nilai Skripsi</strong>
                    </div>

                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $nilai_skripsi->mahasiswa->nama }} ({{ $nilai_skripsi->mahasiswa->nim }})</p>
                                <p class="my-0 py-0">
                                    Seminar Proposal: {{ !empty($nilai_skripsi->seminar_proposal) ? $nilai_skripsi->seminar_proposal : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 
                                    Seminar Hasil: {{ !empty($nilai_skripsi->seminar_hasil) ? $nilai_skripsi->seminar_hasil : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 
                                    Sidang Skripsi: {{ !empty($nilai_skripsi->sidang_skripsi) ? $nilai_skripsi->sidang_skripsi : '-' }} <br> 
                                    Total Nilai: {{ !empty($nilai_skripsi->total) ? $nilai_skripsi->total : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 
                                    Nilai Huruf: {{ !empty($nilai_skripsi->huruf) ? $nilai_skripsi->huruf : '-' }} <span class="d-none d-lg-inline">|</span> <br class="d-lg-none"> 

                                    @if($nilai_skripsi->total >= 60)
                                        <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                    @else
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Lulus</span>
                                    @endif
                                    <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                        <a class="nav-link text-secondary small dropdown-toggle caret-off" href="#" data-toggle="dropdown"><span class="fa fa-cog"></span>&nbsp; Lainnya</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-proposal') }}">Lihat Riwayat Nilai Seminar Proposal</a>
                                            <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-hasil') }}">Lihat Riwayat Nilai Seminar Hasil</a>
                                            <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-sidang-skripsi') }}">Lihat Riwayat Nilai Sidang Skripsi</a>
                                            <a class="dropdown-item" href="{{ url('nilai-ujian/create-by-admin/'.$nilai_skripsi->id_mahasiswa ) }}">Input Nilai Skripsi</a>
                                        </div>
                                    </li>    
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-proposal') }}">Lihat Riwayat Nilai Seminar Proposal</a>
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-hasil') }}">Lihat Riwayat Nilai Seminar Hasil</a>
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/'.$nilai_skripsi->id_mahasiswa.'/detail-sidang-skripsi') }}">Lihat Riwayat Nilai Sidang Skripsi</a>
                                    <a class="dropdown-item" href="{{ url('nilai-ujian/create-by-admin/'.$nilai_skripsi->id_mahasiswa ) }}">Input Nilai Skripsi</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

@stop