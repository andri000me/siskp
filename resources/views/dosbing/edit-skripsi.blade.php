@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Edit Dosen Pembimbing Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/skripsi/'. $dosbing->id, 'method' => 'patch']) !!}
                        {{ csrf_field() }}
                        {!! Form::hidden('id', $dosbing->id) !!}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->mahasiswa->nama }} ({{ $dosbing->mahasiswa->nim }})</label>
                                    {!! Form::hidden('id_mahasiswa', $dosbing->id_mahasiswa) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label> <br>
                                    <label class="font-weight-bold">Skripsi</label>
                                    {!! Form::hidden('ujian', 'skripsi') !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Semester</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->semester->nama }}</label>
                                    {!! Form::hidden('id_semester', $dosbing->id_semester) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing Skripsi Yang Ingin Diganti</label>
                                    {!! Form::select('dosen_salah', $dosen_sekarang, old('dosen_salah'), ['class' => 'form-control dosen', 'placeholder' => 'Dosen Pembimbing', 'style' => 'width:100%', 'required' => 'required']) !!} 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ganti Dengan Dosen</label>
                                    {!! Form::select('dosen_pengganti', $daftar_dosen, old('dosen_pengganti'), ['class' => 'form-control dosen', 'placeholder' => 'Dosen Aktif & Bisa Membimbing', 'style' => 'width:100%', 'required' => 'required']) !!}
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
