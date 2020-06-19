@extends('template')
@section('main')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @include('errors.form_error')
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title">Form Undangan Dosen Penguji</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'jadwal-ujian/undangan']) !!}
                                        {{ csrf_field() }}
                                        {!! Form::hidden('id', $jadwal->id) !!}
                                        {!! Form::hidden('id_mahasiswa', $jadwal->id_mahasiswa) !!}
                                        <div class="row">
                                            <div class="col-md-12">
                                                
                                                <div class="form-group">
                                                    <label>Nomor Surat</label>
                                                    {!! Form::text('nomor_surat', null, ['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <p> {{ $jadwal->mahasiswa->nama }} </p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Program Studi</label>
                                                    <p>{{ !empty($jadwal->mahasiswa->prodi->nama) ? $jadwal->mahasiswa->prodi->nama : '-' }} </p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Hari / Tanggal</label>
                                                     <p> {{ $jadwal->waktu_mulai->formatLocalized("%A, %d %B %Y") }} </p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Tempat</label>
                                                     <p> {{ $jadwal->tempat }} </p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Ujian</label>
                                                     <p> {{ strtoupper($jadwal->ujian) }} </p>
                                                </div>

                                                @foreach($jadwal->dosenPenguji as $penguji)
                                                <div class="form-group">
                                                    <label>Dosen Penguji {{ $penguji->dospeng }}</label>
                                                     <p>{{ $penguji->dosen->nama }}</p>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-file-pdf-o"></i> CETAK
                                        </button>
                                        
                                        <div class="clearfix"></div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop