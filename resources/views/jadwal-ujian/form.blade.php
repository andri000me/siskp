{{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label>Mahasiswa</label>
                                                    @if($jenis === 'Skripsi')
                                                        {!! Form::select('id_mahasiswa', $daftar_mahasiswa, !empty($jadwal) ? $jadwal->id_mahasiswa : old('id_mahasiswa'), ['class' => 'form-control mahasiswa', 'style' => 'width:100%', 'placeholder' => '-- DAFTAR MAHASISWA YANG KONTRAK SKRIPSI --']) !!}
                                                    @elseif($jenis === 'Kerja Praktek')
                                                        {!! Form::select('id_mahasiswa', $daftar_mahasiswa, !empty($jadwal) ? $jadwal->id_mahasiswa : old('id_mahasiswa'), ['class' => 'form-control mahasiswa', 'style' => 'width:100%', 'placeholder' => '-- DAFTAR MAHASISWA YANG KONTRAK MATA KULIAH KERJA PRAKTEK --']) !!}
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label>UJIAN</label>
                                                    @if(Request::segment(2) === 'create-skripsi')
                                                        {!! Form::select('ujian', ['proposal' => 'PROPOSAL', 'hasil' => 'HASIL', 'sidang-skripsi' => 'SIDANG SKRIPSI'], !empty($jadwal) ? $ujian->ujian : old('ujian'), ['class' => 'form-control', 'style' => 'width:100%']) !!}
                                                    @elseif(Request::segment(2) === 'create-kerja-praktek')
                                                        {!! Form::select('ujian', ['kerja-praktek' => 'KERJA PRAKTEK'], !empty($jadwal) ? $jadwal->ujian : old('ujian'), ['class' => 'form-control', 'style' => 'width:100%']) !!}
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label>Tempat</label>
                                                    {!! Form::text('tempat', !empty($jadwal) ? $jadwal->tempat : old('tempat'), ['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    {!! Form::date('waktu', !empty($jadwal) ? $jadwal->waktu : \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Jam Mulai (WITA)</label>
                                                    {!! Form::text('jam_mulai', old('jam_mulai'), ['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label>Jam Selesai (WITA)</label>
                                                    {!! Form::text('jam_selesai', old('jam_selesai'), ['class' => 'form-control']) !!}
                                                </div>

                                                @for($i=1; $i<=$total_penguji; $i++)
                                                <div class="form-group">
                                                    <label>Dosen Penguji {{ $i }}</label>
                                                    {!! Form::select("dospeng[$i][id_dosen]", $daftar_dosen, !empty($jadwal) ? $jadwal->id_dosen : old('id_dosen'), ['class' => 'form-control mahasiswa', 'style' => 'width:100%', 'placeholder' => '-- DAFTAR DOSEN AKTIF & BISA MENGUJI --']) !!}
                                                </div>
                                                @endfor

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i> SUBMIT
                                        </button>

                                        <div class="clearfix"></div>