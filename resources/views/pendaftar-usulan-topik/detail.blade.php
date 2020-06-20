@extends('template')
@section('main')
                @include('errors.form_error')
                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <div class="row">
                    <div class="col-12 col-lg-12 mb-3">
                        <!-- validasi pendaftar -->
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-check"></span> Validasi Usulan Topik </button>
                            
                            <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                {!! Form::open(['url' => 'validasi/usulan-topik']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $usulan_topik->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Tahapan</label>
                                            {!! Form::select('tahapan', ['diperiksa' => 'Diperiksa', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'], $usulan_topik->tahapan, ['class' => 'custom-select']) !!}
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Keterangan</label>
                                            {!! Form::textarea('keterangan', $usulan_topik->keterangan, ['class' => 'form-control', 'style' => 'height:100px']) !!}
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
                    </div>

                </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Usulan Topik</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}"><span class="fa fa-arrow-left"></span> <span class="">Kembali</span></a>
                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama</dt>
                            <dd>{{ $usulan_topik->mahasiswa->nama }}</dd>

                            <dt>Nomor Induk Mahasiswa</dt>
                            <dd>{{ $usulan_topik->mahasiswa->nim }}</dd>

                            <dt>Angkatan</dt>
                            <dd>{{ $usulan_topik->mahasiswa->angkatan }}</dd>

                            <dt>Program Studi</dt>
                            <dd>{{ !empty($usulan_topik->mahasiswa->prodi->nama) ? $usulan_topik->mahasiswa->prodi->nama : '-' }}</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($usulan_topik->mahasiswa->dosen->nama) ? $usulan_topik->mahasiswa->dosen->nama : '-' }}</dd>

                            <dt>Usulan Judul</dt>
                            <dd>{{ $usulan_topik->usulan_judul }}</dd>

                            <dt>Usulan Topik</dt>
                            <dd>{{ $usulan_topik->usulan_topik }}</dd>

                            <dt>Alternatif Judul</dt>
                            <dd>{!! $usulan_topik->alternatif_judul !!}</dd>

                            <dt>Permasalahan</dt>
                            <dd>{!! $usulan_topik->permasalahan !!}</dd>

                            <dt>Tujuan</dt>
                            <dd>{!! $usulan_topik->tujuan !!}</dd>

                            <dt>Manfaat</dt>
                            <dd>{!! $usulan_topik->manfaat !!}</dd>

                            <dt>Tahapan Penelitian</dt>
                            <dd>{!! $usulan_topik->tahapan_penelitian !!}</dd>

                            <dt>Metode Pengembangan Sistem</dt>
                            <dd>{!! $usulan_topik->metode_pengembangan_sistem !!}</dd>

                            <dt>Periode Usulan Topik</dt>
                            <dd>{{ !empty($usulan_topik->periodeDaftarUsulanTopik->nama) ? $usulan_topik->periodeDaftarUsulanTopik->nama : '-' }}</dd>

                            <dt>Tahapan Berkas</dt>
                            @if($usulan_topik->tahapan === 'diperiksa')
                            <dd class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> Diperiksa</dd>
                            @elseif($usulan_topik->tahapan === 'diterima')
                            <dd class="text-info text-capitalize"><i class="fa fa-check"></i> Diterima</dd>
                            @elseif($usulan_topik->tahapan === 'ditolak')
                            <dd class="text-danger text-capitalize"><i class="fa fa-times"></i> Ditolak</dd>
                            @elseif($usulan_topik->tahapan === 'dibatalkan')
                            <span class="text-danger text-capitalize"><i class="fa fa-ban"></i> Dibatalkan</span>
                            @endif
                            
                            <dt>Keterangan Validasi</dt>
                            <dd class="text-dark">{{ $usulan_topik->keterangan }}</dd>

                            <!-- referensi utama -->
                            <?php $i=1 ?>
                            @foreach($usulan_topik->referensiUtama as $referensi)

                            <dt>Referensi (Penelitian Terkait) ke-{{ $i }}</dt>
                            <dd></dd>

                            <dt>Nama Penulis ke-{{ $i }}</dt>
                            <dd>{{ $referensi->nama_penulis }}</dd>

                            <dt>Judul Artikel ke-{{ $i }}</dt>
                            <dd>{{ $referensi->judul_artikel }}</dd>

                            <dt>Jurnal Ilmiah ke-{{ $i }}</dt>
                            <dd>{{ $referensi->jurnal_ilmiah }}</dd>

                            <dt>Keterkaitan ke-{{ $i }}</dt>
                            <dd>{!! $referensi->keterkaitan !!}</dd>

                            <?php $i++ ?>
                            @endforeach

                            <dt>Waktu Daftar</dt>
                            <dd>{{ selisih_waktu($usulan_topik->created_at) }}</dd>                       
                        
                        </dl>
                    </div>

                </div>
            
@stop