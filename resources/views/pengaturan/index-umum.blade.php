@extends('template')
@section('main')
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

                <!-- Usulan Topik -->
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Usulan Topik
                        </strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>
                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/usulan-topik/'. $pengaturan->id, 'method' => 'patch']) !!}
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
                                <div class="form-group col-12">
                                    <label for="">Form Skor & Sertifikat Kompetensi <sup>2</sup> </label>
                                    {!! Form::select('skor_sertifikat_kompetensi', ['wajib' => 'Wajib', 'tidak-wajib' => 'Tidak Wajib', 'hilangkan' => 'Hilangkan'], $pengaturan->skor_sertifikat_kompetensi, ['class' => 'custom-select', 'placeholder' => 'Skor & Sertifikat Kompetensi', 'required' => 'required']) !!}
                                    <small class="form-text text-muted">
                                        <sup>2</sup> Kolom yang wajib diisi oleh mahasiswa saat mendaftar usulan topik
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

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Turun Kerja Praktek</strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>
                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/turun-kp/'. $pengaturan->id, 'method' => 'patch']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Form Scan Persetujuan dari Kantor <sup>3</sup> </label>
                                    {!! Form::select('scan_persetujuan_kantor', ['wajib' => 'Wajib', 'tidak-wajib' => 'Tidak Wajib', 'hilangkan' => 'Hilangkan'], $pengaturan->scan_persetujuan_kantor, ['class' => 'custom-select', 'placeholder' => 'Scan Persetujuan dari Kantor', 'required' => 'required']) !!}
                                    <small class="form-text text-muted">
                                        <sup>3</sup> Kolom yang wajib diisi oleh mahasiswa saat mendaftar turun kerja praktek
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

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Ujian</strong>
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>
                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/ujian/'. $pengaturan->id, 'method' => 'patch']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Form Skor & Sertifikat TOEFL </label>
                                    {!! Form::select('skor_sertifikat_toefl', ['wajib' => 'Wajib', 'tidak-wajib' => 'Tidak Wajib', 'hilangkan' => 'Hilangkan'], $pengaturan->skor_sertifikat_toefl, ['class' => 'custom-select', 'placeholder' => 'Skor & Sertifikat TOEFL', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Form File Laporan </label>
                                    {!! Form::select('file_laporan', ['wajib' => 'Wajib', 'tidak-wajib' => 'Tidak Wajib', 'hilangkan' => 'Hilangkan'], $pengaturan->file_laporan, ['class' => 'custom-select', 'placeholder' => 'File Laporan', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Form File Persetujuan Ujian </label>
                                    {!! Form::select('persetujuan_ujian', ['wajib' => 'Wajib', 'tidak-wajib' => 'Tidak Wajib', 'hilangkan' => 'Hilangkan'], $pengaturan->persetujuan_ujian, ['class' => 'custom-select', 'placeholder' => 'File Persetujuan Ujian', 'required' => 'required']) !!}
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