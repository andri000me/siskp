@extends('template')
@section('main')
                <!-- Referensi Utama -->
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Referensi Utama
                        </strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/referensi-utama/'. $pengaturan->id, 'method' => 'patch']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Jumlah Referensi Utama<sup>1</sup> </label>
                                    {!! Form::text('min_referensi_utama', $pengaturan->min_referensi_utama, ['class' => 'form-control']) !!}
                                    <small class="form-text text-muted">
                                        <sup>1</sup> Jumlah total jurnal ilmiah yang harus diisi oleh mahasiswa saat mendaftar usulan topik   
                                    </small>
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

                <!-- Max file upload -->
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Maksimal Ukuran File Upload</strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>
                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/max-file/'. $pengaturan->id, 'method' => 'patch']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Maksimal Ukuran File Upload (Megabyte)</label>
                                    {!! Form::text('max_file_upload', $pengaturan->max_file_upload / 1024, ['class' => 'form-control']) !!}
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

                {{--
                <!-- Panduan Skripsi -->
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Panduan SISKP</strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>
                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/panduan/'. $pengaturan->id, 'method' => 'patch', 'files' => true]) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Ebook Panduan SISKP (.pdf & maximal {{ $pengaturan->max_file_upload }} Kb)</label>
                                    <div class="mb-2 py-0 custom-file">
                                        <label for="fileUpload" class="custom-file-label">Pilih Panduan</label>
                                        {!! Form::file('panduan_siskp', ['class' => 'custom-file-input', 'id' => 'fileUpload']) !!}
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
                --}}
@stop