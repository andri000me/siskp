@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Nilai Ujian Skripsi oleh Admin</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'nilai-ujian/store-by-admin/' . $mahasiswa->id]) !!}
                        {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Prodi & Angkatan</label> <br>
                                    <label class="font-weight-bold">{{ !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-' }} ({{ $mahasiswa->angkatan }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jenis Ujian Skripsi</label>
                                    {!! Form::select("jenis_ujian", ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], old('jenis_ujian'), ['class' => 'custom-select', 'style' => 'width:100%', 'placeholder' => 'Jenis Ujian', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nilai Ujian (Angka)</label>
                                    {!! Form::text("nilai_ujian", old('nilai_ujian'), ['class' => 'form-control', 'required' => 'required']) !!}
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
