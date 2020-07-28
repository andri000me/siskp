@if(isset($pendaftar_ujian))
    {!! Form::hidden('id_periode_daftar_ujian', $pendaftar_ujian->id_periode_daftar_ujian) !!}
    {!! Form::hidden('id', $pendaftar_ujian->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ujian</label>
                                    @if(Session::has('bisa_kp'))
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], old('ujian'), ['class' => 'custom-select', 'placeholder' => 'Jenis Ujian', 'required' => 'required', 'id' => 'formUjian']) !!}
                                    @else
                                        {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi'], old('ujian'), ['class' => 'custom-select', 'placeholder' => 'Jenis Ujian', 'required' => 'required', 'id' => 'formUjian']) !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-row" id="judulLaporanKp">
                                <div class="form-group col-12">
                                    <label>Judul Laporan KP</label>
                                    {!! Form::textarea('judul_laporan_kp', null, ['class' => 'form-control', 'style' => 'height:80px']) !!}
                                </div>
                            </div>

                        @if($pengaturan->skor_sertifikat_toefl !== 'hilangkan')
                            <div class="form-row formToefl">
                                <div class="form-group col-12">
                                    <label>Skor TOEFL</label>
                                    {!! Form::text('skor_toefl', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-row formToefl">
                                <div class="form-group col-12">
                                    <label>Scan Sertifikat TOEFL </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetTiga"> Pilih File</label>
                                        {!! Form::file('file_sertifikat_toefl', ['class' => 'custom-file-input', 'id' => 'fileTiga']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($pengaturan->file_laporan !== 'hilangkan')
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>File Laporan<sup>*</sup></label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File</label>
                                        {!! Form::file('file_laporan', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                        <small class="form-text text-muted">
                                            <sup>*</sup> ({{ ucwords($pengaturan->file_laporan) }}) laporan (mulai dari cover s/d daftar pustaka), bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($pengaturan->persetujuan_ujian !== 'hilangkan')
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Scan Persetujuan Ujian<sup>**</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetDua"> Pilih File</label>
                                        {!! Form::file('file_lembar_persetujuan', ['class' => 'custom-file-input', 'id' => 'fileDua']) !!}
                                        <small class="form-text text-muted">
                                            <sup>**</sup> ({{ ucwords($pengaturan->persetujuan_ujian) }}) lembar persetujuan ujian yg ditanda tangani oleh 2 dosen pembimbing, bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>