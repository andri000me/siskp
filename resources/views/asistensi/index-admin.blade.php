@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ $total }}</span></a>
                </nav>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Asistensi Online</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_asistensi as $asistensi)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}).  {{ $asistensi->topik_bimbingan }}</p>
                                <p class="my-0 py-0">
                                    <span class="text-capitalize">Asistensi {{ str_replace('-', ' ', $asistensi->jenis) }} </span> 
                                    <br>
                                    Dari {{ $asistensi->mahasiswa->nama }} ({{ $asistensi->mahasiswa->nim }})<br>
                                    Ke {{ $asistensi->dosen->nama }}<br>
                                    {{ $asistensi->detailAsistensi->count() }} komentar <br>
                                    {{ selisih_waktu($asistensi->created_at) }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('asistensi/' . $asistensi->id) }}">Detail</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_asistensi->onEachSide(1)->links() }}
                </nav>
                
@stop