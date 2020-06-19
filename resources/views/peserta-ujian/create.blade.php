@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Tambah Peserta Ujian Seminar</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'peserta-ujian']) !!}
                        {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama Peserta Ujian </label> <br>
                                    {!! Form::hidden('id_mahasiswa', $mahasiswa->id) !!}
                                    <label class="font-weight-bold">{{ $mahasiswa->nama }}</label>
                                </div>
                            </div>
                            @for($i=1; $i<=3; $i++)
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama ke-{{ $i }}</label>
                                    {!! Form::text("mahasiswa[$i][nama]", null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>NIM ke-{{ $i }}</label>
                                    {!! Form::text("mahasiswa[$i][nim]", null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jenis Ujian Seminar ke-{{ $i }}</label>
                                    {!! Form::select("mahasiswa[$i][ujian]", ['proposal' => 'PROPOSAL', 'hasil' => 'HASIL'], old('ujian'), ['class' => 'form-control', 'style' => 'width:100%', 'placeholder' => 'Jenis Ujian']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tanggal Ujian Seminar ke-{{ $i }}</label>
                                    {!! Form::date("mahasiswa[$i][tanggal]", !empty($jadwal) ? $jadwal->waktu : \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            @endfor
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
@stop
