@extends('template')
@section('main')
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Panduan Import Mahasiswa Baru</strong>
                    </div>
                    <div class="card-body border-bottom mb-0 pb-0">
                        <img src="{{ asset('assets/images/IMPORT-MABA.jpg') }}" class="img-fluid text-center border rounded shadow">
                            <p> <br>
                            Kemudian mekanisme Fitur ini adalah sebagai berikut :
                                <ol>
                                    <li>Pada saat tombol Submit ditekan maka pertama sistem akan mengecek NIM Mahasiswa di Database.</li>
                                    <li>Jika NIM Mahasiswa telah ada di Database, maka sistem tidak akan menginput data NIM, Nama, Prodi, Angkatan, & Dosen PA Mahasiswa lagi ke Database.</li>
                                    <li>Jika NIM Mahasiswa belum ada di Database, maka sistem akan menginput data NIM, Nama, Prodi,  Angkatan, & Dosen PA Mahasiswa ke Database.</li>
                                </ol> 
                            </p>        
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Import Mahasiswa Baru</strong>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'mahasiswa/import-maba', 'files' => true]) !!}
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Import Excel (.xlsx)</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File</label>
                                        {!! Form::file('import', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
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