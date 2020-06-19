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
                                        <h4 class="card-title">Ganti Dosen Pembimbing Kerja Praktek</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>

                                    <div class="clearfix"></div>
                                    @if(Session::has('peringatan'))
                                    <div>
                                        <p class="text-danger m-0">{{ Session::get('peringatan') }}</p>
                                    </div>
                                    @endif

                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/'. $dosbing->id, 'method' => 'patch']) !!}
                                        {{ csrf_field() }}
                                        {!! Form::hidden('id', $dosbing->id) !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label>Mahasiswa</label>
                                                    <h4 class="m-0 p-0"> {{ $dosbing->mahasiswa->nama }} </h4>
                                                    {!! Form::hidden('id_mahasiswa', $dosbing->id_mahasiswa) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Pembimbing Ujian</label>
                                                    <h4 class="m-0 p-0"> Kerja Praktek </h4>
                                                    {!! Form::hidden('ujian', 'kerja-praktek') !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Semester</label>
                                                    <h4 class="m-0 p-0"> {{ $dosbing->semester->nama }} </h4>
                                                    {!! Form::hidden('id_semester', $dosbing->id_semester) !!}
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <label>Dosen Pembimbing Kerja Praktek Yang Berhalangan</label>
                                                    {!! Form::select('dosen_berhalangan', $dosen_sekarang, old('dosen_berhalangan'), ['class' => 'form-control dosen', 'placeholder' => '-- Daftar Dosen Pembimbing --', 'style' => 'width:100%']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Dosen Pembimbing Pengganti</label>
                                                    {!! Form::select('dosen_pengganti', $daftar_dosen, old('dosen_pengganti'), ['class' => 'form-control dosen', 'placeholder' => '-- Daftar Dosen Aktif & Bisa Membimbing --', 'style' => 'width:100%']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Status Berhalangan</label>
                                                    {!! Form::select('status', ['tidak-bersedia' => 'TIDAK BERSEDIA', 'mundur' => 'MUNDUR'], old('status'), ['class' => 'form-control dosen', 'placeholder' => '-- Status Berhalangan --', 'style' => 'width:100%']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Berhalangan dengan alasan</label>
                                                    {!! Form::textarea('alasan', null, ['class' => 'form-control', 'style' => 'height:80px']) !!}
                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i> SUBMIT
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