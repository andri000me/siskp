@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Minta Persetujuan Ujian via Online</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'persetujuan-ujian']) !!}
                        {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label>
                                    @if(Session::has('bisa_kp'))
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], old('ujian'), ['class' => 'custom-select', 'placeholder' => 'Jenis Ujian', 'required' => 'required']) !!}
                                    @else
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], old('ujian'), ['class' => 'custom-select', 'placeholder' => 'Jenis Ujian', 'required' => 'required']) !!}
                                    @endif
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
