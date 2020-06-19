@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Tambah Peserta Ujian</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                    {!! Form::open(['url' => 'jadwal-ujian/peserta']) !!}
                        {{ csrf_field() }}
                        {!! Form::hidden('id_jadwal_ujian', $jadwal->id) !!}

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama & NIM</label> <br>
                                    <label class="font-weight-bold">{{ !empty($jadwal->mahasiswa->nama) ? $jadwal->mahasiswa->nama : '-' }} ({{ !empty($jadwal->mahasiswa->nim) ? $jadwal->mahasiswa->nim : '-' }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Prodi & Angkatan</label> <br>
                                    <label class="font-weight-bold">{{ !empty($jadwal->mahasiswa->prodi->nama) ? $jadwal->mahasiswa->prodi->nama : '-' }} ({{ !empty($jadwal->mahasiswa->angkatan) ? $jadwal->mahasiswa->angkatan : '-' }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label> <br>
                                    <label class="font-weight-bold">{{ str_replace('-', ' ', $jadwal->ujian) }})</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tempat</label> <br>
                                    <label class="font-weight-bold">{{ $jadwal->tempat }}</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Waktu</label> <br>
                                    <label class="font-weight-bold">Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</label>
                                </div>
                            </div>

                            @for($i=1; $i<=15; $i++)
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Peserta Ujian ke-{{ $i }}</label>
                                    {!! Form::select("mahasiswa[$i][id_mahasiswa]", $daftar_mahasiswa, old('id_mahasiswa'), ['class' => 'form-control mahasiswa', 'style' => 'width:100%', 'placeholder' => 'Daftar Mahasiswa yg kontrak Skripsi']) !!}
                                </div>
                            </div>
                            @endfor

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>

                </div>
@stop
