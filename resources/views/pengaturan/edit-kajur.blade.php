@extends('template')
@section('main')
                @include('errors.form_error')
                
                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Edit Ketua Jurusan</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'pengaturan/kajur/'. $kajur->id, 'method' => 'patch']) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Dosen</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, $kajur->id_dosen, ['class' => 'form-control dosen', 'placeholder' => 'Daftar Dosen', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Tahun Awal Menjabat</label>
                                    {!! Form::text('tahun_awal', $kajur->tahun_awal, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Tahun Akhir Menjabat</label>
                                    {!! Form::text('tahun_selesai', $kajur->tahun_selesai, ['class' => 'form-control', 'required' => 'required']) !!}
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