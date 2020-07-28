@extends('template')
@section('main')
                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(3) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'jadwal-ujian/'.$tahun.'-'.$bulan.'/cari', 'method' => 'get']) !!}
                        
                        {!! Form::hidden('bulan', $bulan) !!}
                        {!! Form::hidden('tahun', $tahun) !!}

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-3">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-3">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($prodi) ? $prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Ujian</label>
                                    {!! Form::select('ujian', ['kerja-praktek' => 'Seminar Kerja Praktek', 'proposal' => 'Seminar Proposal', 'hasil' => 'Seminar Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], (!empty($ujian) ? $ujian : null), ['placeholder' => 'Jenis Ujian', 'class' => 'custom-select']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('jadwal-ujian/'. $tahun . '-' . $bulan .'/export')  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong>{{ $total }}</strong><br></p>

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span
                            class="far fa-clock"></span> Jadwal Ujian 
                        @switch($bulan)
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
                            {{ $tahun }} </h6>
                    
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">Nama & NIM</th>
                                        <th class="text-center align-middle">Ujian</th>
                                        <th class="text-center align-middle">Tempat & Waktu</th>
                                        <th class="text-center align-middle">Dosen Penguji</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach($daftar_jadwal as $jadwal)
                                    <tr>
                                        <td class="text-center align-middle">{{ $i }}</td>
                                        <td class="align-middle">{{ $jadwal->mahasiswa->nama }} <br> {{ $jadwal->mahasiswa->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                        <td class="align-middle">
                                            {{ $jadwal->tempat }} <br> Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA
                                        </td>
                                        <td class="align-middle">
                                            @foreach($jadwal->dosenPenguji as $penguji)
                                                {{ $penguji->dospeng }}). {{ $penguji->dosen->nama }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center align-middle justify-content-center align-items-center">
                                            <a class="text-dark text-center small d-none d-lg-block" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}"><span class="fa fa-bars fa-lg"></span></a>
                                            
                                            <a class="text-dark text-center small d-lg-none" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}"><span class="fa fa-bars fa-lg"></span></a>
                                            
                                        </td>
                                    </tr>

                                    <?php $i++ ?>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                    
                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_jadwal->onEachSide(1)->links() }}
                </nav>

                        <?php $i=1 ?>
                        @foreach($daftar_jadwal as $jadwal)
                            <!-- modal hapus -->
                            <div class="modal fade" id="modalHapus{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus jadwal ujian <strong>{{ ucwords(str_replace('-', ' ', $jadwal->ujian)) }}</strong> dari <strong>{{ $jadwal->mahasiswa->nama }} ({{ $jadwal->mahasiswa->nim }})</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'jadwal-ujian/'.$jadwal->id , 'method' => 'delete', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$jadwal->id.'/detail') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Ujian</a></p>
                                            
                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'.$jadwal->id_mahasiswa) }}"><i class="fa fa-fw fa-info-circle"></i> Detail Mahasiswa</a></p>

                                            @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil' || $jadwal->ujian === 'sidang-skripsi')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-skripsi/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara</a></p>
                                                                
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-skripsi-ttd/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara (Ada Nilai & TTD)</a></p>

                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/administrasi-ujian/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Administrasi Ujian</a></p>
                                                        
                                                @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil')
                                                    <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/detail-peserta/'. $jadwal->id ) }}"><i class="fa fa-fw fa-street-view"></i> Detail Peserta Ujian</a></p>
                                                @endif
                                            @endif
                                                                
                                            @if($jadwal->ujian === 'kerja-praktek')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-kerja-praktek/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara</a></p>

                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-kerja-praktek-ttd/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara (Ada Nilai & TTD)</a></p>
                                                                    
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-administrasi-ujian-kp/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Administrasi Ujian</a></p>
                                            @endif
                                                                
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modalHapus{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" href="{{ url('nilai-ujian/'.$jadwal->id.'/detail') }}"><i class="fa fa-fw fa-check-double"></i> Detail Nilai Ujian</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('mahasiswa/'.$jadwal->id_mahasiswa) }}"><i class="fa fa-fw fa-info-circle"></i> Detail Mahasiswa</a></p>
                                            
                                            @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil' || $jadwal->ujian === 'sidang-skripsi')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-skripsi/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara</a></p>
                                                                
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-skripsi-ttd/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara (Ada Nilai & TTD)</a></p>

                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/administrasi-ujian/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Administrasi Ujian</a></p>
                                                        
                                                @if($jadwal->ujian === 'proposal' || $jadwal->ujian === 'hasil')
                                                    <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/detail-peserta/'. $jadwal->id ) }}"><i class="fa fa-fw fa-street-view"></i> Detail Peserta Ujian</a></p>
                                                @endif
                                            @endif
                                                                
                                            @if($jadwal->ujian === 'kerja-praktek')
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-kerja-praktek/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara</a></p>

                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-berita-acara-kerja-praktek-ttd/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Berita Acara (Ada Nilai & TTD)</a></p>
                                                                    
                                                <p><a class="d-block text-dark" href="{{ url('jadwal-ujian/form-administrasi-ujian-kp/'. $jadwal->id ) }}"><i class="fa fa-fw fa-download"></i> Unduh Administrasi Ujian</a></p>
                                            @endif
                                                                
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modalHapus{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php $i++ ?>
                        @endforeach
@stop