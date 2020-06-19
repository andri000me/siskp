@if(isset($usulan_topik))
    {!! Form::hidden('id_periode_daftar_usulan_topik', $usulan_topik->id_periode_daftar_usulan_topik) !!}
    {!! Form::hidden('id', $usulan_topik->id) !!}
@endif
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Usulan Topik</label>
                                    {!! Form::text('usulan_topik', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Usulan Judul</label>
                                    {!! Form::textarea('usulan_judul', null, ['class' => 'form-control', 'style' => 'height:80px', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Alternatif Judul</label>
                                    {!! Form::textarea('alternatif_judul', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Permasalahan</label>
                                    {!! Form::textarea('permasalahan', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tujuan</label>
                                    {!! Form::textarea('tujuan', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Manfaat</label>
                                    {!! Form::textarea('manfaat', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Metode Penelitian</label>
                                    {!! Form::textarea('metode_penelitian', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Metode Pengembangan Sistem</label>
                                    {!! Form::textarea('metode_pengembangan_sistem', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Tahapan Penelitian</label>
                                    {!! Form::textarea('tahapan_penelitian', null, ['class' => 'form-control borang' ]) !!}
                                </div>
                            </div>

                        @if(!empty($usulan_topik))
                            <?php $i=1 ?>
                            @foreach($usulan_topik->referensiUtama as $referensi)
                            {!! Form::hidden("referensi[$i][id]", $referensi->id) !!}
                            <h6>Referensi Utama (Jurnal Ilmiah terkait) Ke-{{ $i }}</h6>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama Penulis Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][nama_penulis]", $referensi->nama_penulis, ['class' => 'form-control', 'placeholder' => 'Contoh: Adnan Kasim' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Artikel Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][judul_artikel]", $referensi->judul_artikel, ['class' => 'form-control', 'placeholder' => 'Contoh: Rancang Bangun Portal Organisasi Mahasiswa (PORSMA) Untuk Membantu Pengelolaan Kegiatan Kemahasiswaan di Universitas Negeri Gorontalo' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jurnal Ilmiah (Nama Jurnal, Volume, Nomor, & Tahun) Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][jurnal_ilmiah]", $referensi->jurnal_ilmiah, ['class' => 'form-control', 'placeholder' => 'Contoh: Jambura Journal of Informatics, Vol. 1, No.1, Maret 2020' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Keterkaitan dengan Usulan Judul Skripsi Ke-{{ $i }}</label>
                                    {!! Form::textarea("referensi[$i][keterkaitan]", $referensi->keterkaitan, ['class' => 'form-control borang', 'placeholder' => 'Jelaskan Persamaan dan Perbedaan Antara Usulan Penelitian Anda dengan Jurnal Yang Anda Kutip' ]) !!}
                                </div>
                            </div>

                            <?php $i++ ?>
                            @endforeach
                        @else
                            <?php $i=1 ?>
                            @for($i=1; $i<=$pengaturan->min_referensi_utama; $i++)

                            <h6>Referensi Utama (Jurnal Ilmiah terkait) Ke-{{ $i }}</h6>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama Penulis Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][nama_penulis]", null, ['class' => 'form-control', 'placeholder' => 'Contoh: Adnan Kasim' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Judul Artikel Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][judul_artikel]", null, ['class' => 'form-control', 'placeholder' => 'Contoh: Rancang Bangun Portal Organisasi Mahasiswa (PORSMA) Untuk Membantu Pengelolaan Kegiatan Kemahasiswaan di Universitas Negeri Gorontalo' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Jurnal Ilmiah (Nama Jurnal, Volume, Nomor, & Tahun) Ke-{{ $i }}</label>
                                    {!! Form::text("referensi[$i][jurnal_ilmiah]", null, ['class' => 'form-control', 'placeholder' => 'Contoh: Jambura Journal of Informatics, Vol. 1, No.1, Maret 2020' ]) !!}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Keterkaitan dengan Usulan Judul Skripsi Ke-{{ $i }}</label>
                                    {!! Form::textarea("referensi[$i][keterkaitan]", null, ['class' => 'form-control borang', 'placeholder' => 'Jelaskan Persamaan dan Perbedaan Antara Usulan Penelitian Anda dengan Jurnal Yang Anda Kutip' ]) !!}
                                </div>
                            </div>

                            @endfor
                        @endif
                            
                            
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-paper-plane"></span> Submit</button>
                                </div>
                            </div>