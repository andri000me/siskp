@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Upload Laporan & Jurnal Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'revisi-skripsi', 'files' => true]) !!}
                            {{ csrf_field() }}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Laporan Skripsi<sup>1</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetDua"> Pilih File Laporan</label>
                                        {!! Form::file('file_laporan', ['class' => 'custom-file-input', 'id' => 'fileDua', 'required' => 'required']) !!}
                                        <small class="form-text text-muted">
                                            <sup>1</sup> laporan (mulai dari cover s/d daftar pustaka), bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Jurnal Skripsi<sup>2</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File Laporan</label>
                                        {!! Form::file('file_jurnal_skripsi', ['class' => 'custom-file-input', 'id' => 'fileSatu', 'required' => 'required']) !!}
                                        <small class="form-text text-muted">
                                            <sup>2</sup> jurnal skripsi, bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb)
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
