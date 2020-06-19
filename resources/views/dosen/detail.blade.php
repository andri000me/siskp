@extends('template')
@section('main')
                @include('errors.form_error')
                
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataSatu"><span class="fa fa-check"></span> Validasi Status </button>
                            
                            <div id="DataSatu" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'dosen/validasi-status']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $dosen->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Status</label>
                                            {!! Form::select('status', ['aktif' => 'Aktif', 'tidak-aktif' => 'Tidak Aktif', 'cuti' => 'Cuti'], $dosen->status, ['class' => 'custom-select', 'placeholder' => 'Status Aktif', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>                    
                    </div>

                    <div class="col-12 col-lg-4 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataDua"><span class="fa fa-check"></span> Status Penguji </button>
                            
                            <div id="DataDua" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'dosen/bisa-menguji']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $dosen->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Bisa Menguji</label>
                                            {!! Form::select('bisa_menguji', ['ya' => 'Ya', 'tidak' => 'Tidak'], $dosen->bisa_menguji, ['class' => 'custom-select', 'placeholder' => 'Bisa Menguji ?', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>                    
                    </div>

                    <div class="col-12 col-lg-4 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataTiga"><span class="fa fa-check"></span> Status Pembimbing </button>
                            
                            <div id="DataTiga" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'dosen/bisa-membimbing']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $dosen->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Bisa Membimbing</label>
                                            {!! Form::select('bisa_membimbing', ['ya' => 'Ya', 'tidak' => 'Tidak'], $dosen->bisa_membimbing, ['class' => 'custom-select', 'placeholder' => 'Bisa Membimbing ?', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>                    
                    </div>
                    
                </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Dosen</strong>

                        @if(Session::has('dosen') && Session::get('id') === $dosen->id)
                            <a class="text-white" href="{{ url('dosen/'.Session::get('id').'/edit') }}"><span class="fa fa-edit"></span> <span class="">Edit</span></a>
                        @elseif(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <a class="text-white" href="{{ url('dosen/'.$dosen->id.'/edit' ) }}"><span class="fa fa-edit"></span> <span class="">Edit</span></a>
                        @endif

                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama</dt>
                            <dd>{{ $dosen->nama }}</dd>

                            <dt>Nomor Induk Pegawai</dt>
                            <dd>{{ $dosen->nip }}</dd>

                            <dt>Program Studi</dt>
                            <dd>{{ $dosen->prodi->nama }}</dd>

                            <dt>Status</dt>
                            @if($dosen->status === 'cuti')
                            <dd class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> Cuti</dd>
                            @elseif($dosen->status === 'aktif')
                            <dd class="text-info text-capitalize"><i class="fa fa-check"></i> Aktif</dd>
                            @elseif($dosen->status === 'tidak-aktif')
                            <dd class="text-danger text-capitalize"><i class="fa fa-times"></i> Tidak Aktif</dd>
                            @endif

                            <dt>Bisa Menguji ?</dt>
                            @if($dosen->bisa_menguji === 'ya')
                            <dd class="text-info text-capitalize"><i class="fa fa-check"></i> Bisa</dd>
                            @elseif($dosen->bisa_menguji === 'tidak')
                            <dd class="text-danger text-capitalize"><i class="fa fa-times"></i> Tidak</dd>
                            @endif

                            <dt>Bisa Membimbing ?</dt>
                            @if($dosen->bisa_membimbing === 'ya')
                            <dd class="text-info text-capitalize"><i class="fa fa-check"></i> Bisa</dd>
                            @elseif($dosen->bisa_membimbing === 'tidak')
                            <dd class="text-danger text-capitalize"><i class="fa fa-times"></i> Tidak</dd>
                            @endif
                            
                            <dt>Mahasiswa PA belum lulus KP</dt>
                            <dd class="text-dark">{{ $total_maspa_kp }} Mahasiswa</dd>

                            <dt>Mahasiswa PA belum lulus Skripsi</dt>
                            <dd class="text-dark">{{ $total_maspa_skripsi }} Mahasiswa</dd>

                            <dt>Mahasiswa Bimbingan KP belum lulus KP</dt>
                            <dd class="text-dark">{{ $total_masbing_kp }} Mahasiswa</dd>

                            <dt>Mahasiswa Bimbingan Skripsi belum lulus Skripsi</dt>
                            <dd class="text-dark">{{ $total_masbing_skripsi }} Mahasiswa</dd>

                            <!-- tanda tangan -->
                            <dt>Tanda Tangan (.png)</dt>
                            <!-- Jika file ada -->
                            @if(isset($dosen->tanda_tangan))
                            <dd>
                               <img src="{{ asset('assets/ttd/' . $dosen->tanda_tangan) }}" class="img-fluid shadow"> 
                            </dd>
                            <!-- jika file kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif

                        </dl>
                    </div>

                </div>
            
@stop