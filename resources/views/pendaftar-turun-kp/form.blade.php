@if(isset($turun_kp))
    {!! Form::hidden('id_periode_daftar_turun_kp', $turun_kp->id_periode_daftar_turun_kp) !!}
    {!! Form::hidden('id', $turun_kp->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama Instansi</label>
                                    {!! Form::text('instansi', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Alamat Instansi</label>
                                    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>
                        
                        @if($pengaturan->scan_persetujuan_kantor !== 'hilangkan')
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label> Scan Persetujuan Dari Kantor<sup>1</sup> </label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih File </label>
                                        {!! Form::file('file_lembar_persetujuan', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                        <small class="form-text text-muted">
                                            <sup>1</sup> ({{ ucwords($pengaturan->scan_persetujuan_kantor) }}) lembar persetujuan yg ditanda tangani oleh pimpinan instansi terkait, bertipe .pdf & ukuran max {{ $pengaturan->max_file_upload / 1024 }} Mb
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