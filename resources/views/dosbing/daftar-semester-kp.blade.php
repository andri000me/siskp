@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm mb-2 btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(5) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/semester/'. $id .'/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Lokasi</label>
                                    {!! Form::text('lokasi', (!empty($lokasi) ? $lokasi : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Pembimbing Utama</label>
                                    {!! Form::select('dosbing_satu_kp', $daftar_dosen, (!empty($dosbing_satu_kp) ? $dosbing_satu_kp : null), ['placeholder' => 'Pembimbing Utama', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Pembimbing Pendamping</label>
                                    {!! Form::select('dosbing_dua_kp', $daftar_dosen, (!empty($dosbing_dua_kp) ? $dosbing_dua_kp : null), ['placeholder' => 'Pembimbing Pendamping', 'class' => 'custom-select dosen', 'style' => 'width:100%']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('id_semester', $id) !!}

                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('dosen-pembimbing/kerja-praktek/semester/'. $id .'/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&lokasi=' . Request::get('lokasi') .
                                     '&dosbing_satu_kp=' . Request::get('dosbing_satu_kp') .
                                     '&dosbing_dua_kp=' . Request::get('dosbing_dua_kp') .
                                     '&id_semester=' . $id
                                     ) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ number_format($total, 0, ',', '.') }}</span></a>
                    
                    <a class="text-dark d-lg-none" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetNon"><span class="fa fa-ellipsis-h"></span></a>

                    <a class="text-dark d-none d-lg-inline" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetNonLg"><span class="fa fa-ellipsis-h"></span></a>
                </nav>
                
                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetNonLg" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#perpanjangYangBelumLulus" data-dismiss="modal"><i class="fa fa-fw fa-user-clock"></i> Perpanjang yang belum lulus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetNon" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#perpanjangYangBelumLulus" data-dismiss="modal"><i class="fa fa-fw fa-user-clock"></i> Perpanjang yang belum lulus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal perpanjang yang belum lulus -->
                            <div class="modal fade" id="perpanjangYangBelumLulus" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-primary text-center pb-3"> <i class="fa fa-info-circle"></i> Konfirmasi</h5>
                                            <p>
                                                Yakin memperpanjang pembimbing kerja praktek ke semester aktif bagi mahasiswa yang belum lulus di semester ini ?
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/' . $id . '/perpanjang-belum-lulus', 'class' => 'col']) !!}
                                                    {!! Form::hidden('id_semester', $id) !!}
                                                    <button type="submit" class="btn btn-block btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pembimbing Kerja Praktek {{ $semester->nama }}</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <?php $i=1 ?>
                @foreach($daftar_dosbing as $dosbing)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($dosbing->mahasiswa->nama) ? $dosbing->mahasiswa->nama : '-' }} ({{ !empty($dosbing->mahasiswa->nim) ? $dosbing->mahasiswa->nim : '-' }}) </p>
                                <p class="my-0 py-0">
                                    {{ !empty($dosbing->mahasiswa->prodi->nama) ? $dosbing->mahasiswa->prodi->nama : '-' }} ({{ !empty($dosbing->mahasiswa->angkatan) ? $dosbing->mahasiswa->angkatan : '-' }})<br>
                                    Instansi: {{ $dosbing->lokasi }} <br>
                                    Tahapan KP: {{ ucwords(str_replace('_', ' ', $dosbing->mahasiswa->tahapan_kp)) }} <br>
                                    Pembimbing <br>
                                    1). {{ !empty($dosbing->dosbingSatuKp->nama) ? $dosbing->dosbingSatuKp->nama : '-' }} <br>
                                    2). {{ !empty($dosbing->dosbingDuaKp->nama) ? $dosbing->dosbingDuaKp->nama : '-' }}
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-dark mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#sheet{{ $i }}"><span class="fa fa-cog"></span>&nbsp; Lainnya</a></li>
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small" href="#" style="cursor:pointer" data-toggle="modal" data-target="#sheetLg{{ $i }}">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                            </div>

                            <!-- modal sheet -->
                            <div class="modal fade" id="sheet{{ $i }}" tabindex="-1">
                                <div class="d-lg-none d-flex modal-dialog" style="position:absolute; bottom:0; width:100%; margin:0; padding:0;">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            {{--
                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/'.$dosbing->id.'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>
                                            --}}
                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#modalPerpanjang{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-user-clock"></i> Perpanjang ke semester aktif</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/form-surat-persetujuan-kp/'.$dosbing->id) }}"><i class="fa fa-fw fa-download"></i> Unduh surat persetujuan ujian seminar</a></p>
                                                                    
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapus{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- modal sheet lg -->
                            <div class="modal fade" id="sheetLg{{ $i }}" tabindex="-1">
                                <div class="d-none d-lg-flex modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 pb-0">
                                            {{--
                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/'.$dosbing->id.'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>
                                            --}}
                                            <p><a class="d-block text-dark" style="cursor:pointer" data-toggle="modal" data-target="#modalPerpanjang{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-user-clock"></i> Perpanjang ke semester aktif</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('dosen-pembimbing/kerja-praktek/form-surat-persetujuan-kp/'.$dosbing->id) }}"><i class="fa fa-fw fa-download"></i> Unduh surat persetujuan ujian seminar</a></p>
                                                                    
                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#hapus{{ $i }}" data-dismiss="modal"><i class="fa fa-fw fa-trash"></i> Hapus</a></p>

                                            <button type="button" class="btn btn-light btn-sm text-dark btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="hapus{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-danger text-center pb-3"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <p>
                                                Yakin menghapus dosen pembimbing dari <strong>{{ $dosbing->mahasiswa->nama }} ({{ $dosbing->mahasiswa->nim }})</strong> ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/'.$dosbing->id , 'method' => 'delete', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal perpanjang ke semester aktif -->
                            <div class="modal fade" id="modalPerpanjang{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-dark h6 text-center">
                                            <h5 class="modal-title text-primary text-center pb-3"> <i class="fa fa-info-circle"></i> Konfirmasi</h5>
                                            <p>
                                                Yakin memperpanjang dosen pembimbing dari <strong>{{ $dosbing->mahasiswa->nama }} ({{ $dosbing->mahasiswa->nim }})</strong> ke semester aktif ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                                {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/'.$dosbing->id .'/perpanjang', 'method' => 'post', 'class' => 'col']) !!}
                                                    <button type="submit" class="btn btn-block btn-primary btn-sm text-light"><i class="fa fa-paper-plane"></i> Submit</button>
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
                    {{ $daftar_dosbing->onEachSide(1)->links() }}
                </nav>
@stop