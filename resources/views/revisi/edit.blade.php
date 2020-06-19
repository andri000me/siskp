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
                                        <h4 class="card-title">Edit Revisi Skripsi</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'revisi-skripsi/' . $revisi->id, 'files' => true, 'method' => 'patch']) !!}
                                        {{ csrf_field() }}
                                        
                                        {!! Form::hidden('id', $revisi->id) !!}

                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label> File Laporan (Bertipe pdf & Ukuran maximal {{ $pengaturan->max_file_upload / 1024 }} Mb)</label>
                                                    {!! Form::file('file_laporan', ['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label> File Jurnal Skripsi (Bertipe pdf & Ukuran maximal {{ $pengaturan->max_file_upload / 1024 }} Mb)</label>
                                                    {!! Form::file('file_jurnal_skripsi', ['class' => 'form-control']) !!}
                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i> SUBMIT
                                        </button>
                                        
                                        <div class="clearfix"></div>

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop