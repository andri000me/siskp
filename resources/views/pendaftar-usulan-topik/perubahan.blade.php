@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Perubahan Judul Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::model($usulan_topik, ['method' => 'patch', 'action' =>   ['PendaftarUsulanTopikController@updatePerubahan', $usulan_topik->id]]) !!}
                        @if(isset($usulan_topik))
                            {!! Form::hidden('id', $usulan_topik->id) !!}
                        @endif
                        {{ csrf_field() }}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Skripsi Lama</label> <br>
                                    <strong>{{ $usulan_topik->usulan_judul }}</strong>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Skripsi Baru</label> <br>
                                    {!! Form::textarea('judul_baru', null, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>

                            {{--
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Alasan Perubahan Judul Skripsi</label> <br>
                                    {!! Form::textarea('alasan', null, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>
                            --}}
                            
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>
                        
                        {!! Form::close() !!}
                    </div>

                </div>
@stop
