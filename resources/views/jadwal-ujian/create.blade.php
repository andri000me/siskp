@extends('template')
@section('main')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @include('errors.form_error')
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">

                                    <div class="float-left">
                                        <h4 class="card-title">Tambah Jadwal Ujian {{ $jenis }}</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="card-body">
                                @if($jenis === 'Skripsi')
                                    {!! Form::open(['url' => 'jadwal-ujian']) !!}
                                @elseif($jenis === 'Kerja Praktek')
                                    {!! Form::open(['url' => 'jadwal-ujian/kerja-praktek']) !!}
                                @endif
                                        @include('jadwal-ujian.form')
                                    {!! Form::close() !!}    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop