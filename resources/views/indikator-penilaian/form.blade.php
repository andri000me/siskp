                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    {!! Form::text('nama', !empty($penilaian) ? $penilaian->nama : old('nama'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Bobot (%)</label>
                                    {!! Form::text('bobot', !empty($penilaian) ? $penilaian->bobot : old('bobot'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label>
                                    {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], !empty($penilaian) ? $penilaian->ujian : old('ujian'), ['class' => 'custom-select', 'style' => 'width:100%', 'placeholder' => '-- Jenis Ujian --', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nilai Minimum (1-100)</label>
                                    {!! Form::text('nilai_min', !empty($penilaian) ? $penilaian->nilai_min : old('nilai_min'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nilai Maksimum (1-100)</label>
                                    {!! Form::text('nilai_max', !empty($penilaian) ? $penilaian->nilai_max : old('nilai_max'), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>