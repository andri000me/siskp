@extends('template')
@section('main')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @include('errors.form_error')
                        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title">Panduan & Mekanisme Import Dosen</h4>
                                        <p>
                                            Fitur Import Dosen ini bertujuan untuk memasukan data semua Dosen yang ada di Jurusan Teknik Informatika secara masal sekaligus, adapun format file Excel yang harus dipersiapkan adalah seperti digambar dibawah ini: 
                                        </p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/IMPORT-DOSEN.png') }}" class="img" width="100%">
                                    <p>
                                        Kemudian mekanisme Fitur ini adalah sebagai berikut :
                                        <ol>
                                            <li>Pada saat tombol Submit ditekan maka pertama sistem akan mengecek NIP Dosen di Database.</li>
                                            <li>Jika NIP Dosen telah ada di Database, maka sistem tidak akan menginput data NIP, Nama Dosen, status, bisa menguji, bisa membimbing & Program Studi lagi ke Database.</li>
                                            <li>Jika NIP Dosen belum ada di Database, maka sistem akan menginput data NIP, Nama Dosen, status, bisa membimbing, bisa menguji, Program Studi & password defaultnya adalah NIP Masing-masing dosen ke Database. Kemudian Dosen bisa masuk ke sistem dengan menggunakan NIP sebagai username & NIP juga sebagai password Defaultnya</li>
                                        </ol> 
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title">Import Daftar Dosen via Excel</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'dosen/import', 'files' => true]) !!}
                                        
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label> Import Semua Dosen </label>
                                                    {!! Form::file('import_status', ['class' => 'form-control', 'id' => 'import_status']) !!}
                                                    <p id="target"></p>
                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i> SUBMIT
                                        </button>

                                        <div class="clearfix"></div>

                                        <script>
                                            var file = document.getElementById("import_status");

                                            file.addEventListener('change', function(){
                                                document.getElementById("target").innerHTML = "Nama File : "+file.files[0].name;
                                            })
                                        
                                        </script>

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop