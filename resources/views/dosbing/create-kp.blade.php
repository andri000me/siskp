@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Pembimbing Kerja Praktek</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek']) !!}
                            {{ csrf_field() }}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Mahasiswa</label>
                                    {!! Form::select('id_mahasiswa', $daftar_mahasiswa, old('id_mahasiswa'), ['class' => 'form-control mahasiswa', 'placeholder' => 'Mahasiswa yang Kontrak KP', 'style' => 'width:100%', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing Utama</label>
                                    {!! Form::select('dosbing_satu_kp', $daftar_dosen, !empty($dosbing) ? $dosbing->dosbing_satu_kp : old('dosbing_satu_kp'), ['class' => 'form-control dosen', 'placeholder' => 'Dosen Aktif & Bisa Membimbing', 'style' => 'width:100%', 'required' => 'required']) !!} 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing Pendamping</label>
                                    {!! Form::select('dosbing_dua_kp', $daftar_dosen, !empty($dosbing) ? $dosbing->dosbing_dua_kp : old('dosbing_dua_kp'), ['class' => 'form-control dosen', 'placeholder' => 'Dosen Aktif & Bisa Membimbing', 'style' => 'width:100%', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Semester</label>
                                    {!! Form::select('id_semester', $daftar_semester, !empty($dosbing) ? $dosbing->id_semester : old('id_semester'), ['placeholder' => 'Daftar Semester', 'class' => 'form-control semester', 'style' => 'width:100%', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Lokasi</label>
                                    {!! Form::text('lokasi', !empty($dosbing) ? $dosbing->lokasi : old('lokasi'), ['class' => 'form-control', 'required' => 'required']) !!}
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
