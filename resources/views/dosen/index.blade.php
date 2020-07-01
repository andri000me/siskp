@extends('template')
@section('main')
                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(2) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'dosen/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">NIP</label>
                                    {!! Form::text('nip', (!empty($nip) ? $nip : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($prodi) ? $prodi : null), ['placeholder' => 'Daftar Program Studi', 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Status</label>
                                    {!! Form::select('status', ['aktif' => 'Aktif', 'tidak-aktif' => 'Tidak Aktif', 'cuti' => 'Cuti'], (!empty($status) ? $status : null), ['placeholder' => 'Daftar Status', 'class' => 'custom-select']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Bisa Menguji</label>
                                    {!! Form::select('bisa_menguji', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($bisa_menguji) ? $bisa_menguji : null), ['placeholder' => 'Bisa Menguji ?', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Bisa Membimbing</label>
                                    {!! Form::select('bisa_membimbing', ['ya' => 'Ya', 'tidak' => 'Tidak'], (!empty($bisa_membimbing) ? $bisa_membimbing : null), ['placeholder' => 'Bisa Membimbing ?', 'class' => 'custom-select']) !!}
                                </div>
                            </div>
                        
                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('dosen/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&nip=' . Request::get('nip') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&status=' . Request::get('status') .
                                     '&bisa_menguji=' . Request::get('bisa_menguji') .
                                     '&bisa_membimbing=' . Request::get('bisa_membimbing')) }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong >{{ $total_dosen }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Daftar Dosen</strong>
                        
                        <a class="text-white" href="{{ url('dosen/create') }}">
                            <span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span>
                        </a>

                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_dosen as $dosen)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $dosen->nama }}</p>
                                <p class="my-0 py-0">
                                    NIP: {{ $dosen->nip }} <br>
                                    {{ !empty($dosen->prodi->nama) ? $dosen->prodi->nama : '-' }} <br>
                                    @if($dosen->status === 'cuti')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Cuti</span>
                                    @elseif($dosen->status === 'aktif')
                                        <span class="text-primary"><i class="fa fa-check"></i> Aktif</span>
                                    @elseif($dosen->status === 'tidak-aktif')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Aktif</span>
                                    @endif
                                    &nbsp;

                                    @if($dosen->bisa_menguji === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Bisa Menguji</span>
                                    @elseif($dosen->bisa_menguji === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Bisa Menguji</span>
                                    @endif
                                    &nbsp;

                                    @if($dosen->bisa_membimbing === 'ya')
                                        <span class="text-primary"><i class="fa fa-check"></i> Bisa Membimbing</span>
                                    @elseif($dosen->bisa_membimbing === 'tidak')
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Bisa Membimbing</span>
                                    @endif
                                    <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('dosen/'. $dosen->id) }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>
                                        
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-success mx-0 px-0 small" href="{{ url('dosen/'. $dosen->id .'/edit') }}"><span class="fa fa-edit"></span>&nbsp; Edit</a></li>
                                        
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-danger mx-0 px-0 small" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}"><span class="fa fa-trash"></span>&nbsp; Hapus</a></li>
                                        
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
                                            
                                            <p><a class="d-block text-dark" href="{{ url('dosen/'. $dosen->id) }}"><i class="fa fa-fw fa-info-circle"></i> Detail</a></p>

                                            <p><a class="d-block text-dark" href="{{ url('dosen/'. $dosen->id .'/edit') }}"><i class="fa fa-fw fa-edit"></i> Edit</a></p>

                                            <p><a class="d-block text-danger" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}" data-dismiss="modal"> <i class="fa fa-fw fa-trash"></i> Hapus</a></p>

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
                                                Yakin menghapus <strong>{{ $dosen->nama }}</strong> sebagai Dosen ? Data yang sudah dihapus tidak bisa dikembalikan.
                                            </p>
                                            <div class="row">
                                                <button type="button" class="col btn btn-light btn-sm btn-block text-dark" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                                            
                                                {!! Form::open(['url' => 'dosen/'.$dosen->id , 'method' => 'delete', 'class' => 'col']) !!}
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
                    {{ $daftar_dosen->onEachSide(1)->links() }}
                </nav>
@stop