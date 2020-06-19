@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Ajukan Asistensi Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'asistensi', 'files' => true]) !!}
                            {{ csrf_field() }}
                            {!! Form::hidden('id_mahasiswa', Session::get('id')) !!}
                            {!! Form::hidden('is_mahasiswa', '1') !!}
                            {!! Form::hidden('jenis', 'kerja-praktek') !!}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Topik Bimbingan<sup>1</sup> </label>
                                    {!! Form::text('topik_bimbingan', old('topik_bimbingan'), ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Identifikasi permasalahan']) !!}
                                    <small class="form-text text-muted">
                                        <sup>1</sup> Hal apa yang akan anda konsultasikan
                                    </small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, old('id_dosen'), ['class' => 'custom-select', 'placeholder' => 'Dosen Pembimbing', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Isi</label>
                                    {!! Form::textarea('isi', old('isi'), ['class' => 'form-control borang', 'style' => 'height:150px']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Pendukung<sup>2</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File</label>
                                        {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                        <small class="form-text text-muted">
                                            <sup>2</sup> (Opsional) Bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
                                        </small>
                                    </div>
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
