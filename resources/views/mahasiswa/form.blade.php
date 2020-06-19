{{ csrf_field() }}
@if(isset($mahasiswa))
    {!! Form::hidden('id', $mahasiswa->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Induk Mahasiswa</label>
                                    {!! Form::text('nim', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Angkatan Masuk</label>
                                    {!! Form::text('angkatan', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, $mahasiswa->id_prodi, ['class' => 'custom-select', 'placeholder' => 'Semua Program Studi', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Password</label>
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Dosen Pendampingan Akademik</label>
                                    {!! Form::select('id_dosen', $daftar_dosen, $mahasiswa->id_dosen, ['class' => 'custom-select dosen', 'placeholder' => 'Semua Dosen Aktif', 'required' => 'required', 'style' => 'width:100%']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>