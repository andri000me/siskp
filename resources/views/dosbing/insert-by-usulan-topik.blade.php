@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Dosen Pembimbing Skripsi</strong>

                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/skripsi/store-by-usulan-topik']) !!}
                            {{ csrf_field() }}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->nama }}</strong>
                                    {!! Form::hidden('id_mahasiswa', $pendaftar->id_mahasiswa) !!}
                                    {!! Form::hidden('id_pendaftar_usulan_topik', $pendaftar->id) !!}
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
                                    <strong>Skripsi</strong>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Skripsi</label> <br>
                                    <strong>{{ $pendaftar->usulan_judul }}</strong>
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
                                    {!! Form::select('dosbing_satu_skripsi', $daftar_dosen, old('dosbing_satu_skripsi'), ['class' => 'form-control dosen', 'placeholder' => 'Daftar Dosen', 'required' => 'required', 'style' => 'width:100%']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing Pendamping (Dua)</label>
                                    {!! Form::select('dosbing_dua_skripsi', $daftar_dosen, old('dosbing_dua_skripsi'), ['class' => 'form-control dosen', 'placeholder' => 'Daftar Dosen', 'required' => 'required', 'style' => 'width:100%']) !!}
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
