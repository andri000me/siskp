@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Judul Skripsi oleh Admin</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pendaftaran/usulan-topik/store-by-admin']) !!}
                        {{ csrf_field() }}
                        {!! Form::hidden('id_mahasiswa', $mahasiswa->id) !!}
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
                                    <label>Usulan Topik</label>
                                    {!! Form::text('usulan_topik', old('usulan_topik'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Usulan Judul</label>
                                    {!! Form::textarea('usulan_judul', old('usulan_judul'), ['class' => 'form-control', 'style' => 'height:200px', 'required' => 'required']) !!}
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
