@extends('template')
@section('main')
                @include('errors.form_error')

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Usulan Topik sebelum adanya SISKP</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_periode_kosong as $pendaftar)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-truncate my-0 py-0">{{ $i }}). {{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0 text-capitalize text-truncate">
                                    {{ $pendaftar->usulan_judul }}<br>
                                    @if($pendaftar->tahapan === 'diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                    @elseif($pendaftar->tahapan === 'diterima')
                                        <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                    @elseif($pendaftar->tahapan === 'ditolak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                    @elseif($pendaftar->tahapan === 'dibatalkan')
                                        <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                    @endif
                                    <br>
                                    <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/usulan-topik/'.$pendaftar->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a>
                                        </li>
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a>
                                        </li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('pendaftaran/usulan-topik/'.$pendaftar->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modal{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus judul skripsi dari <strong>{{ $pendaftar->mahasiswa->nama }} ({{ $pendaftar->mahasiswa->nim }})</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'pendaftaran/usulan-topik/'.$pendaftar->id ,'method' => 'delete', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
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
                    {{ $daftar_periode_kosong->onEachSide(1)->links() }}
                </nav>
@stop