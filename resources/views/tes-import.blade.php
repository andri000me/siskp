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
                                        <h4 class="card-title">Import via Excel</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'tes', 'files' => true]) !!}
                                        
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label> Import Mahasiswa </label>
                                                    {!! Form::file('import', ['class' => 'form-control']) !!}
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