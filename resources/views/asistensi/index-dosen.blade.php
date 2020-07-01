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
                                    {{ $asistensi->detailAsistensi->count() }} komentar <br>
                                    {{ selisih_waktu($asistensi->created_at) }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>

                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><span class="fa fa-comments"></span>&nbsp; Komentar</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            
                                            <p><a class="d-block text-dark" href="{{ url('asistensi/' . $asistensi->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><i class="fa fa-fw fa-comments"></i> Komentar</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
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