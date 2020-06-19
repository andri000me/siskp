@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pembimbing Skripsi Anda</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_dosbing as $dosbing)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($dosbing->semester->nama) ? $dosbing->semester->nama : '-' }} </p>
                                <p class="my-0 py-0">
                                    1). {{ $dosbing->dosbingSatuSkripsi->nama }} <br>
                                    2). {{ $dosbing->dosbingDuaSkripsi->nama }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-secondary small dropdown-toggle caret-off" href="#"
                                                data-toggle="dropdown">
                                                <span class="fa fa-cog"></span>&nbsp; Lainnya
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="{{ url('dosen-pembimbing/skripsi/surat-kesediaan/'.$dosbing->id) }}" class="dropdown-item"> Unduh Pernyataan Pembimbing</a>
                                                
                                                <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-proposal/'.$dosbing->id) }}">Unduh Persetujuan Proposal</a>
                            
                                                <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-hasil/'.$dosbing->id) }}">Unduh Persetujuan Hasil</a>
                                                
                                                <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-sidang/'.$dosbing->id) }}">Unduh Persetujuan Sidang Skripsi</a>
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
                                    <a href="{{ url('dosen-pembimbing/skripsi/surat-kesediaan/'.$dosbing->id) }}" class="dropdown-item"> Unduh Pernyataan Pembimbing</a>
                                                
                                    <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-proposal/'.$dosbing->id) }}">Unduh Persetujuan Proposal</a>
                            
                                    <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-hasil/'.$dosbing->id) }}">Unduh Persetujuan Hasil</a>
                                                
                                    <a class="dropdown-item" href="{{ url('dosen-pembimbing/skripsi/surat-persetujuan-sidang/'.$dosbing->id) }}">Unduh Persetujuan Sidang Skripsi</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                </div>
                
@stop