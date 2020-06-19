@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Edit Pendaftaran Ujian</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::model($pendaftar, ['method' => 'patch', 'files' => true, 'action' =>   ['PendaftarUjianController@update', $pendaftar->id]]) !!}
                            {{ csrf_field() }}
                            @include('pendaftar-ujian.form')
                        {!! Form::close() !!}
                    </div>

                </div>
@stop
