@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Input Jadwal Ujian</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>
                    </div>

                    <div class="card-body border-bottom py-2">
                        @if($pendaftar->ujian === 'proposal' || $pendaftar->ujian === 'hasil' || $pendaftar->ujian === 'sidang-skripsi')
                            {!! Form::open(['url' => 'jadwal-ujian']) !!}
                        @elseif($pendaftar->ujian === 'kerja-praktek')
                            {!! Form::open(['url' => 'jadwal-ujian/kerja-praktek']) !!}
                        @endif
                            {{ csrf_field() }}
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->nama }}</strong> 
                                    {!! Form::hidden('id_mahasiswa', $pendaftar->id_mahasiswa) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Induk Mahasiswa</label> <br>
                                    <strong>{{ $pendaftar->mahasiswa->nim }}</strong> 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label> <br>
                                    <strong class="text-capitalize">{{ str_replace('-', ' ', $pendaftar->ujian) }}</strong>
                                    {{ Form::hidden('ujian', $pendaftar->ujian) }}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing</label> <br>
                                    <strong>
                                        @if($pendaftar->ujian === 'proposal' || $pendaftar->ujian === 'hasil' || $pendaftar->ujian === 'sidang-skripsi')
                                        1). {{ $dosbing->dosbingSatuSkripsi->nama }}
                                        <br>
                                        2). {{ $dosbing->dosbingDuaSkripsi->nama }}
                                        @else
                                        1). {{ $dosbing->dosbingSatuKp->nama }}
                                        <br>
                                        2). {{ $dosbing->dosbingDuaKp->nama }}
                                        @endif
                                    </strong>
                                </div>
                            </div>

                        <?php $i=1 ?>
                        @if(!empty($jadwal->dosenPenguji))
                            @foreach($jadwal->dosenPenguji as $penguji)
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Penguji {{ $i }}</label>
                                    {!! Form::select("dospeng[$i][id_dosen]", $daftar_dosen, !empty($jadwal) ? $penguji->id_dosen : old('id_dosen'), ['class' => 'form-control dosen', 'style' => 'width:100%', 'placeholder' => 'Dosen Aktif & Bisa Menguji', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <?php $i++ ?>
                            @endforeach
                        @else
                            @for($i=1; $i<=$total_penguji; $i++)
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Penguji {{ $i }}</label>
                                    {!! Form::select("dospeng[$i][id_dosen]", $daftar_dosen, !empty($jadwal) ? $jadwal->dosenPenguji->id_dosen : old('id_dosen'), ['class' => 'form-control dosen', 'style' => 'width:100%', 'placeholder' => 'Dosen Aktif & Bisa Menguji', 'required' => 'required']) !!}
                                </div>
                            </div>
                            @endfor
                        @endif

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tempat</label>
                                    {!! Form::text('tempat', !empty($jadwal) ? $jadwal->tempat : old('tempat'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tanggal</label>
                                    {!! Form::date('waktu', !empty($jadwal) ? $jadwal->waktu : \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jam Mulai</label>
                                    {!! Form::text('jam_mulai', old('jam_mulai'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jam Selesai</label>
                                    {!! Form::text('jam_selesai', old('jam_selesai'), ['class' => 'form-control', 'required' => 'required']) !!}
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
