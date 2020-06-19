@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Progres Bimbingan 
                        @if(Request::segment(2) === 'create-proposal')
                                            Proposal
                        @elseif(Request::segment(2) === 'create-hasil')
                            Hasil
                        @elseif(Request::segment(2) === 'create-sidang-skripsi')
                            Sidang Skripsi
                        @elseif(Request::segment(2) === 'create-kerja-praktek')
                            Kerja Praktek
                        @endif
                        </strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'bimbingan']) !!}
                            {{ csrf_field() }}
                            {!! Form::hidden('id_mahasiswa', Session::get('id')) !!}

                            @if(Request::segment(2) === 'create-proposal')
                                {!! Form::hidden('bimbingan', 'proposal') !!}
                            @elseif(Request::segment(2) === 'create-hasil')
                                {!! Form::hidden('bimbingan', 'hasil') !!}
                            @elseif(Request::segment(2) === 'create-sidang-skripsi')
                                {!! Form::hidden('bimbingan', 'sidang-skripsi') !!}
                            @elseif(Request::segment(2) === 'create-kerja-praktek')
                                {!! Form::hidden('bimbingan', 'kerja-praktek') !!}
                            @endif
                                        
                            @include('bimbingan.form')
                        {!! Form::close() !!}
                    </div>

                </div>
@stop
