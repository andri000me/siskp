@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Form Berita Acara Skripsi</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        {!! Form::open(['url' => 'jadwal-ujian/berita-acara-skripsi']) !!}
                        {{ csrf_field() }}
                        {!! Form::hidden('id', $jadwal->id) !!}
                        {!! Form::hidden('id_mahasiswa', $jadwal->id_mahasiswa) !!}
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Surat</label>
                                    {!! Form::text('nomor_surat', old('nomor_surat'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ $jadwal->mahasiswa->nama }} ({{ $jadwal->mahasiswa->nim }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Program Studi</label> <br>
                                    <label class="font-weight-bold">{{ $jadwal->mahasiswa->prodi->nama }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label> <br>
                                    <label class="font-weight-bold text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tempat & Waktu</label> <br>
                                    <label class="font-weight-bold">
                                        {{ $jadwal->tempat }}, Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Penguji</label> <br>
                                    <label class="font-weight-bold">
                                        @foreach($jadwal->dosenPenguji as $penguji)
                                            {{ $penguji->dospeng }}). {{ $penguji->dosen->nama }} <br>
                                        @endforeach
                                    </label>
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
