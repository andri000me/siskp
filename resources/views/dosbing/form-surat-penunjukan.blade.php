@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Form Surat Penunjukan Pembimbing Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/skripsi/surat-penunjukan']) !!}
                        {{ csrf_field() }}
                        @if(isset($dosbing))
                            {!! Form::hidden('id', $dosbing->id) !!}
                        @endif

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Surat</label> <br>
                                    {!! Form::text('nomor_surat', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->mahasiswa->nama }} ({{ $dosbing->mahasiswa->nim }})</label>
                                    {!! Form::hidden('id_mahasiswa', $dosbing->id_mahasiswa) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Skripsi</label> <br>
                                    <label class="font-weight-bold">{{ !empty($judul->usulan_judul) ? $judul->usulan_judul : '-' }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing Utama</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->dosbingSatuSkripsi->nama }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing Pendamping</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->dosbingDuaSkripsi->nama }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-download"></span> Unduh</button>
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>

                </div>
@stop
