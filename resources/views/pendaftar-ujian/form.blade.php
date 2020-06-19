@if(isset($pendaftar_ujian))
    {!! Form::hidden('id_periode_daftar_ujian', $pendaftar_ujian->id_periode_daftar_ujian) !!}
    {!! Form::hidden('id', $pendaftar_ujian->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label>
                                    @if(Session::has('bisa_kp'))
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], old('ujian'), ['class' => 'form-control', 'placeholder' => 'Jenis Ujian', 'required' => 'required']) !!}
                                    @else
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], old('ujian'), ['class' => 'form-control', 'placeholder' => 'Jenis Ujian', 'required' => 'required']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Laporan<sup>1</sup></label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File</label>
                                        {!! Form::file('file_laporan', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                        <small class="form-text text-muted">
                                            <sup>1</sup> (opsional) laporan (mulai dari cover s/d daftar pustaka), bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Scan Persetujuan Ujian<sup>2</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetDua"> Pilih File</label>
                                        {!! Form::file('file_lembar_persetujuan', ['class' => 'custom-file-input', 'id' => 'fileDua']) !!}
                                        <small class="form-text text-muted">
                                            <sup>2</sup> (opsional) lembar persetujuan ujian yg ditanda tangani oleh 2 dosen pembimbing, bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>