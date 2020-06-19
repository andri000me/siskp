@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">Asistensi Online Saya</strong>

                        @if(Session::has('bisa_kp'))
                        <div class="dropdown dropleft">
                            <a class="text-white dropdown-toggle caret-off" href="#" data-toggle="dropdown"><span class="fa fa-plus"></span> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ url('asistensi/create-skripsi') }}">Skripsi</a>
                                <a class="dropdown-item" href="{{ url('asistensi/create-kerja-praktek') }}">Kerja Praktek</a>
                            </div>
                        </div>
                        @else
                        <a class="text-white" href="{{ url('asistensi/create-skripsi') }}"><span class="fa fa-plus"></span> <span class=""></span></a>   
                        @endif                     
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
                                    Pada {{ $asistensi->dosen->nama }} <br>
                                    {{ $asistensi->detailAsistensi->count() }} komentar <br>
                                    {{ selisih_waktu($asistensi->created_at) }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>

                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><span class="fa fa-comments"></span>&nbsp; Komentar</a></li>

                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a></li>
                                        
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('asistensi/' . $asistensi->id) }}">Detail</a>
                                    <a class="dropdown-item" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}">Komentar</a>
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}">Hapus</a>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modal{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-light">
                                            <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-dark h6">
                                            Yakin menghapus data ini ? Data yang sudah dihapus tidak bisa dikembalikan.
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['url' => 'asistensi/'.$asistensi->id , 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
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