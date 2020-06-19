@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Form Persetujuan Ujian KP</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'dosen-pembimbing/kerja-praktek/surat-persetujuan-kp']) !!}
                        {{ csrf_field() }}
                        @if(isset($dosbing))
                            {!! Form::hidden('id', $dosbing->id) !!}
                        @endif

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->mahasiswa->nama }} ({{ $dosbing->mahasiswa->nim }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Laporan </label>
                                    {!! Form::textarea('judul', null, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing Utama</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->dosbingSatuKp->nama }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Pembimbing Pendamping</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->dosbingDuaKp->nama }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Instansi</label> <br>
                                    <label class="font-weight-bold">{{ $dosbing->lokasi }}</label>
                                    {!! Form::hidden('instansi', $dosbing->lokasi) !!}
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
