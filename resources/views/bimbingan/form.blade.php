@if(isset($bimbingan))
    {!! Form::hidden('id', $bimbingan->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Waktu</label>
                                    {!! Form::date('waktu', !empty($bimbingan->waktu) ? $bimbingan->waktu : \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pembimbing</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, !empty($bimbingan) ? $bimbingan->id_dosen : old('id_dosen'), ['class' => 'form-control', 'style' => 'width:100%', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Konsultasi</label>
                                    {!! Form::textarea('konsultasi', !empty($bimbingan->konsultasi) ? $bimbingan->konsultasi : old('konsultasi'), ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>