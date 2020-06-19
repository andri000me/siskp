@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Edit Indikator Penilaian</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/penilaian/'. $penilaian->id, 'method' => 'patch']) !!}
                            {{ csrf_field() }}
                            @include('indikator-penilaian.form')
                        {!! Form::close() !!}
                    </div>

                </div>
@stop
