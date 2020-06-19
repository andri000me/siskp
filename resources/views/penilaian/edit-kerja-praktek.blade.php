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
                                    {!! Form::open(['url' => 'nilai-ujian/'. $id .'/kerja-praktek', 'method' => 'patch']) !!}
                                        {{ csrf_field() }}
                                        
                                        <?php $i=1 ?>
                                        @foreach($daftar_nilai as $nilai)
                                            {!! Form::hidden("nilai[$i][id]", $nilai->id) !!}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                    <div class="form-group">
                                                        <label>Dosen</label>
                                                        <p class="my-0 py-0">{{ $nilai->dosen->nama }}</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Teknik Presentasi (0-100)</label>
                                                        {!! Form::text("nilai[$i][teknik_presentasi]", ($nilai->teknik_presentasi) ? $nilai->teknik_presentasi : null, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Penulisan Laporan (0-100)</label>
                                                        {!! Form::text("nilai[$i][penulisan_laporan]", ($nilai->penulisan_laporan) ? $nilai->penulisan_laporan : null, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Analisis & Perancangan (0-100)</label>
                                                        {!! Form::text("nilai[$i][analisis_dan_perancangan]", ($nilai->analisis_dan_perancangan) ? $nilai->analisis_dan_perancangan : null, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Penguasaan Program (0-100)</label>
                                                        {!! Form::text("nilai[$i][penguasaan_program]", ($nilai->penguasaan_program) ? $nilai->penguasaan_program : null, ['class' => 'form-control']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kualitas Jawaban (0-100)</label>
                                                        {!! Form::text("nilai[$i][kualitas_jawaban]", ($nilai->kualitas_jawaban) ? $nilai->kualitas_jawaban : null, ['class' => 'form-control']) !!}
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                        <?php $i++ ?>
                                        @endforeach

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