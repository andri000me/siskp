@extends('template')
@section('main')
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Panduan Import Skripsi & KP</strong>
                    </div>
                    <div class="card-body border-bottom mb-0 pb-0">
                        <img src="{{ asset('assets/images/IMPORT-MAHASISWA.jpg') }}" class="img-fluid text-center border rounded shadow">
                            <p> <br>
                            Kemudian mekanisme Fitur ini adalah sebagai berikut :
                                <ol>
                                    <li>Pada saat tombol Submit ditekan maka pertama sistem akan mengecek NIM Mahasiswa di Database.</li>
                                    <li>Jika NIM Mahasiswa telah ada di Database, maka sistem tidak akan menginput data NIM, Nama, Prodi & Angkatan Mahasiswa lagi ke Database.</li>
                                    <li>Jika NIM Mahasiswa belum ada di Database, maka sistem akan menginput data NIM, Nama, Prodi, & Angkatan Mahasiswa & password defaultnya adalah NIM Masing-masing mahasiswa ke Database. Kemudian Mahasiswa bisa masuk ke sistem dengan menggunakan NIM sebagai username & NIM juga sebagai password Defaultnya</li>
                                </ol> 
                            </p>        
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Import Mahasiswa Skripsi & KP</strong>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'mahasiswa/import', 'files' => true]) !!}
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label> Fitur </label>
                                    {!! Form::select('fitur', [ 
                                        'kontrak_skripsi' => 'Kontrak MK Skripsi',
                                        'kontrak_kp' => 'Kontrak MK KP'
                                    ], old('fitur'), ['class' => 'custom-select', 'placeholder' => 'Daftar Fitur', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Import Excel (.xlsx)</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File</label>
                                        {!! Form::file('import', ['class' => 'custom-file-input', 'id' => 'fileSatu', 'required' => 'required']) !!}
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