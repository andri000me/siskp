@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Dosen Pembimbing Kerja Praktek</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/store-by-turun-kp']) !!}
                            {{ csrf_field() }}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->nama }}</strong> 
                                    {!! Form::hidden('id_mahasiswa', $pendaftar->id_mahasiswa) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Induk Mahasiswa</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->nim }}</strong> 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing</label> <br>
                                    <strong>Kerja Praktek</strong>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Instansi</label> <br>
                                    <strong>{{ $pendaftar->instansi }}</strong>
                                    {!! Form::hidden('lokasi', $pendaftar->instansi) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Alamat</label> <br>
                                    <strong>{{ $pendaftar->alamat }}</strong>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pendamping Akademik</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->dosen->nama }}</strong>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing Utama (Satu)</label>
                                    {!! Form::select('dosbing_satu_kp', $daftar_dosen, old('dosbing_satu_kp'), ['class' => 'form-control dosen', 'placeholder' => 'Daftar Dosen', 'required' => 'required', 'style' => 'width:100%']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing Pendamping (Dua)</label>
                                    {!! Form::select('dosbing_dua_kp', $daftar_dosen, old('dosbing_dua_kp'), ['class' => 'form-control dosen', 'placeholder' => 'Daftar Dosen', 'required' => 'required', 'style' => 'width:100%']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Semester</label>
                                    {!! Form::select('id_semester', $daftar_semester, old('id_semester'), ['class' => 'custom-select', 'placeholder' => 'Daftar Semester', 'required' => 'required']) !!}
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
@stop
