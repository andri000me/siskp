@extends('template')
@section('main')
                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light"> Periode Usulan Topik</strong>
                        
                        <a class="text-white " href="{{ url('semester-periode/periode-daftar-usulan-topik/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>

                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_periode_usulan_topik as $periode)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <strong class="card-title">{{ $i }}). {{ $periode->nama }}</strong>
                                <p class="my-0 py-0">
                                    Dari hari {{ tanggal($periode->waktu_buka) }} s/d hari {{tanggal($periode->waktu_tutup)  }}
                                </p>
                                <span class="text-dark"> 
                                Semester {{ $periode->semester->nama }} <br>
                                {{ $periode->pendaftarUsulanTopik->count() }} Mahasiswa
                    
                                    <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/usulan-topik/periode/'.$periode->id) }}"><span
                                                    class="fa fa-info-circle"></span>&nbsp;
                                                Detail</a>
                                        </li>
                                    </ul>
                            </div>
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('pendaftaran/usulan-topik/periode/'.$periode->id) }}">
                                    <span class="fa fa-info-circle fa-lg"></span> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                    @if($total_periode_kosong)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <strong class="card-title">{{ $i }}). Tidak Diketahui</strong>
                                <p class="my-0 py-0">
                                    Daftar Pendaftar Usulan Topik sebelum SISKP diimplementasikan
                                </p>
                                <span class="text-dark"> 
                                {{ $total_periode_kosong }} Mahasiswa
                    
                                    <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/usulan-topik/periode/tidak-diketahui') }}"><span
                                                    class="fa fa-info-circle"></span>&nbsp;
                                                Detail</a>
                                        </li>
                                    </ul>
                            </div>
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('pendaftaran/usulan-topik/periode/tidak-diketahui') }}">
                                    <span class="fa fa-info-circle fa-lg"></span> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_periode_usulan_topik->onEachSide(1)->links() }}
                </nav>
@stop