@extends('template')
@section('main')
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Daftar Peserta Seminar</strong>
                    </div>

                <!-- jika data ada -->
            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <?php $i=1 ?>
                @foreach($daftar_mahasiswa as $mahasiswa)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</p>
                                <p class="my-0 py-0">
                                    {{ $mahasiswa->prodi->nama }} <br>
                                    {{ $mahasiswa->pesertaUjian->count() + $mahasiswa->pesertaUjianLama->count() }} Kali
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    @if($mahasiswa->pesertaUjian->count() + $mahasiswa->pesertaUjianLama->count())
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('peserta-ujian/'. $mahasiswa->id ) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                    @endif
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-primary mx-0 px-0 small" href="{{ url('peserta-ujian/lama/'.$mahasiswa->id) }}"><span class="fa fa-plus"></span>&nbsp; Tambah</a></li>
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
                                        @if($mahasiswa->pesertaUjian->count() + $mahasiswa->pesertaUjianLama->count())
                                            <p><a class="d-block text-dark" href="{{ url('peserta-ujian/'. $mahasiswa->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>
                                        @endif

                                            <p><a class="d-block text-dark" href="{{ url('peserta-ujian/lama/'.$mahasiswa->id) }}"><i class="fa fa-fw fa-plus"></i> Tambah</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                @elseif(Session::has('mahasiswa'))

                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Nama & NIM</th>
                                        <th class="text-center align-middle">Ujian</th>
                                        <th class="text-center align-middle">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta_ujian as $peserta)
                                    <tr>
                                        <td class="text-left align-middle">{{ $peserta->jadwalUjian->mahasiswa->nama }} <br> {{ $peserta->jadwalUjian->mahasiswa->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $peserta->jadwalUjian->ujian) }}</td>
                                        <td class="align-middle">{{ tanggal($peserta->jadwalUjian->waktu_mulai) }}</td>
                                    </tr>
                                    @endforeach

                                    @foreach($peserta_ujian_lama as $peserta)
                                    <tr>
                                        <td class="align-middle text-left">{{ $peserta->nama }} <br> {{ $peserta->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $peserta->ujian) }}</td>
                                        <td class="align-middle">{{ tanggal($peserta->tanggal) }}</td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endif

                </div>

                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_mahasiswa->onEachSide(1)->links() }}
                </nav>
                @endif
@stop