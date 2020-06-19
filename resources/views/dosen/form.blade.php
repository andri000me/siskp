@if(isset($dosen))
    {!! Form::hidden('id', $dosen->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nomor Induk Pegawai</label>
                                    {!! Form::text('nip', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, null, ['class' => 'custom-select', 'placeholder' => 'Semua Program Studi', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Password</label>
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Status</label>
                                    {!! Form::select('status', ['aktif' => 'Aktif', 'tidak-aktif' => 'Tidak Aktif', 'cuti' => 'Cuti'], null, ['class' => 'custom-select', 'placeholder' => 'Status', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Bisa Menguji</label>
                                    {!! Form::select('bisa_menguji', ['ya' => 'Ya', 'tidak' => 'Tidak'], null, ['class' => 'custom-select', 'placeholder' => 'Bisa Menguji ?', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Bisa Membimbing</label>
                                    {!! Form::select('bisa_membimbing', ['ya' => 'Ya', 'tidak' => 'Tidak'], null, ['class' => 'custom-select', 'placeholder' => 'Bisa Membimbing ?', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tanda Tangan (Warna Latar Dihapus, & Tipe PNG)</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" id="targetSatu"> Pilih Tanda Tangan</label>
                                        {!! Form::file('tanda_tangan', ['class' => 'custom-file-input', 'id' => 'fileSatu']) !!}
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>