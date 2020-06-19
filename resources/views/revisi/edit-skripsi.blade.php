@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Edit Judul & Upload Jurnal Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'riwayat-skripsi/' . $mahasiswa->id . '/revisi', 'files' => true, 'method' => 'patch']) !!}
                            {{ csrf_field() }}
                            {!! Form::hidden('id_mahasiswa', $mahasiswa->id) !!}
                            {!! Form::hidden('id_pendaftar_usulan_topik', $judul->id) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Skripsi</label>
                                    {!! Form::textarea('usulan_judul', $judul->usulan_judul, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Jurnal Skripsi (.pdf & max {{ $pengaturan->max_file_upload / 1024 }} Mb)</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File Jurnal</label>
                                        {!! Form::file('file_jurnal_skripsi', ['class' => 'custom-file-input', 'id' => 'fileSatu', 'required' => 'required']) !!}
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
