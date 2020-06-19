@extends('template')
@section('main')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @include('errors.form_error')
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title">Edit Penilaian Seminar Kerja Praktek</h4>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url' => 'nilai-ujian/'. $id .'/kerja-praktek/dosen', 'method' => 'patch']) !!}
                                        {{ csrf_field() }}
                                        
                                        {!! Form::hidden('id', $nilai->id) !!}
                                        {!! Form::hidden('id_mahasiswa', $nilai->jadwalUjian->id_mahasiswa) !!}

                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                    <div class="form-group">
                                                        <label>Mahasiswa</label>
                                                        <p class="my-0 py-0">{{ $nilai->jadwalUjian->mahasiswa->nama }}</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Waktu</label>
                                                        <p class="my-0 py-0">{{ $nilai->jadwalUjian->waktu_mulai->formatLocalized("%A, %d %B %Y") }} Pukul {{ date('H:i', strtotime($nilai->jadwalUjian->waktu_mulai)) }} - {{ date('H:i', strtotime($nilai->jadwalUjian->waktu_selesai)) }} WITA</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Teknik Presentasi (0-100)</label>
                                                        {!! Form::text("teknik_presentasi", $nilai->teknik_presentasi, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Penulisan Laporan (0-100)</label>
                                                        {!! Form::text("penulisan_laporan", $nilai->penulisan_laporan, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Analisis & Perancangan (0-100)</label>
                                                        {!! Form::text("analisis_dan_perancangan", $nilai->analisis_dan_perancangan, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Penguasaan Program (0-100)</label>
                                                        {!! Form::text("penguasaan_program", $nilai->penguasaan_program, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kualitas Jawaban (0-100)</label>
                                                        {!! Form::text("kualitas_jawaban", $nilai->kualitas_jawaban, ['class' => 'form-control']) !!}
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i> SUBMIT
                                        </button>
                                        
                                        <div class="clearfix"></div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop