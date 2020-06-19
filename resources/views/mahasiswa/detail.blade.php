@extends('template')
@section('main')
                @include('errors.form_error')
                
            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                <div class="row">
                @if(!empty($bisa_kp))
                    <!-- validasi kontrak skripsi -->
                    <div class="col-12 col-lg-3 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataSatu"><span class="fa fa-check"></span> Validasi Kontrak Skripsi </button>
                            
                            <div id="DataSatu" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-skripsi') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Kontrak Skripsi</label>
                                            {!! Form::select('kontrak_skripsi', ['ya' => 'Ya', 'tidak' => 'Tidak'], $mahasiswa->kontrak_skripsi, ['class' => 'custom-select']) !!}
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

                    <!-- validasi kontrak kerja praktek -->
                    <div class="col-12 col-lg-3 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataDua"><span class="fa fa-check"></span> Validasi Kontrak Kerja Praktek </button>
                            
                            <div id="DataDua" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-kp') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Kontrak Kerja Praktek</label>
                                            {!! Form::select('kontrak_kp', ['ya' => 'Ya', 'tidak' => 'Tidak'], $mahasiswa->kontrak_kp, ['class' => 'custom-select']) !!}
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

                    <!-- validasi tahapan skripsi -->
                    <div class="col-12 col-lg-3 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-block btn-sm" type="button" data-toggle="collapse" data-target="#DataTiga"><span class="fa fa-check"></span> Validasi Tahapan Skripsi </button>
                            
                            <div id="DataTiga" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-tahapan-skripsi') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Tahapan Skripsi</label>
                                            {!! Form::select('tahapan_skripsi', ['persiapan' => 'Persiapan', 'pendaftaran_topik' => 'Pendaftaran Topik', 'penyusunan_propoasl' => 'Penyusunan Proposal', 'pendaftaran_proposal' => 'Pendaftaran Proposal', 'ujian_seminar_proposal' => 'Ujian Seminar Proposal', 'penulisan_skripsi' => 'Penulisan Skripsi', 'pendaftaran_hasil' => 'Pendaftaran Hasil', 'ujian_seminar_hasil' => 'Ujian Seminar Hasil', 'revisi_skripsi' => 'Revisi Skripsi', 'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi', 'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi', 'lulus' => 'Lulus'], $mahasiswa->tahapan_skripsi, ['class' => 'custom-select']) !!}
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

                    <!-- validasi tahapan kerja praktek -->
                    <div class="col-12 col-lg-3 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataEmpat"><span class="fa fa-check"></span> Validasi Tahapan Kerja Praktek </button>
                            
                            <div id="DataEmpat" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-tahapan-kp') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Tahapan Kerja Praktek</label>
                                            {!! Form::select('tahapan_kp', ['persiapan' => 'Persiapan', 'pendaftaran' => 'Pendaftaran', 'ujian_seminar' => 'Ujian Seminar', 'revisi' => 'Revisi', 'lulus' => 'Lulus'], $mahasiswa->tahapan_kp, ['class' => 'custom-select']) !!}
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
                @else
                    <!-- validasi kontrak skripsi -->
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#DataSatu"><span class="fa fa-check"></span> Validasi Kontrak Skripsi </button>
                            
                            <div id="DataSatu" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-skripsi') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Kontrak Skripsi</label>
                                            {!! Form::select('kontrak_skripsi', ['ya' => 'Ya', 'tidak' => 'Tidak'], $mahasiswa->kontrak_skripsi, ['class' => 'custom-select']) !!}
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

                    <!-- validasi tahapan skripsi -->
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="accordion mb-2" id="filter">
                            <button class="btn btn-outline-primary btn-block btn-sm" type="button" data-toggle="collapse" data-target="#DataTiga"><span class="fa fa-check"></span> Validasi Tahapan Skripsi </button>
                            
                            <div id="DataTiga" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                                <form action="{{ url('mahasiswa/validasi-tahapan-skripsi') }}" method="POST">
                                {{ csrf_field() }}
                                {!! Form::hidden('id', $mahasiswa->id) !!}
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="">Tahapan Skripsi</label>
                                            {!! Form::select('tahapan_skripsi', ['persiapan' => 'Persiapan', 'pendaftaran_topik' => 'Pendaftaran Topik', 'penyusunan_propoasl' => 'Penyusunan Proposal', 'pendaftaran_proposal' => 'Pendaftaran Proposal', 'ujian_seminar_proposal' => 'Ujian Seminar Proposal', 'penulisan_skripsi' => 'Penulisan Skripsi', 'pendaftaran_hasil' => 'Pendaftaran Hasil', 'ujian_seminar_hasil' => 'Ujian Seminar Hasil', 'revisi_skripsi' => 'Revisi Skripsi', 'pendaftaran_sidang_skripsi' => 'Pendaftaran Sidang Skripsi', 'ujian_sidang_skripsi' => 'Ujian Sidang Skripsi', 'lulus' => 'Lulus'], $mahasiswa->tahapan_skripsi, ['class' => 'custom-select']) !!}
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
                @endif
                </div>
            @endif

                <!-- profil -->
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Mahasiswa</strong>

                        @if(Session::has('mahasiswa'))
                            <a class="text-white" href="{{ url('mahasiswa/'.Session::get('id').'/edit') }}"><span class="fa fa-edit"></span> <span class="">Edit</span></a>
                        @elseif(Session::has('kajur') || Session::has('kaprodi') || Session::has('admin'))
                            <a class="text-white" href="{{ url('mahasiswa/'.$mahasiswa->id.'/edit' ) }}"><span class="fa fa-edit"></span> <span class="">Edit</span></a>
                        @endif

                    </div>
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</dd>

                            <dt>Program Studi & Angkatan</dt>
                            <dd>{{ !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-' }} ({{ $mahasiswa->angkatan }})</dd>

                            <dt>Dosen Pendamping Akademik</dt>
                            <dd>{{ !empty($mahasiswa->dosen->nama) ? $mahasiswa->dosen->nama : '-' }}</dd>
                            
                            @if(Session::has('mahasiswa') && Session::has('bisa_kp'))
                            <dt>Kontrak Kerja Praktek</dt>
                            <dd>
                                @if($mahasiswa->kontrak_kp === 'ya') <span class="text-primary"><i class="fa fa-check"></i> Kontrak</span>
                                @else <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak</span>
                                @endif  
                            </dd>
                            @endif

                        @if(Session::has('kajur') || Session::has('admin') || Session::has('kaprodi'))
                            @if(!empty($bisa_kp))
                            <dt>Kontrak Kerja Praktek</dt>
                            <dd>
                                @if($mahasiswa->kontrak_kp === 'ya') <span class="text-primary"><i class="fa fa-check"></i> Kontrak</span>
                                @else <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak</span>
                                @endif  
                            </dd>
                            @endif
                        @endif

                            <dt>Kontrak Skripsi</dt>
                            <dd>
                                @if($mahasiswa->kontrak_skripsi === 'ya') <span class="text-primary"><i class="fa fa-check"></i> Kontrak</span>
                                @else <span class="text-danger"><i class="fa fa-times"></i> Tidak Kontrak</span>
                                @endif  
                            </dd>

                            @if(Session::has('mahasiswa') && Session::has('bisa_kp'))
                            <dt>Tahapan Kerja Praktek</dt>
                            <dd>
                                @if($mahasiswa->tahapan_kp === 'lulus') <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                @else <span class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> {{ str_replace('_', ' ', $mahasiswa->tahapan_kp) }}</span>
                                @endif  
                            </dd>
                            @endif

                        @if(Session::has('kajur') || Session::has('admin') || Session::has('kaprodi'))
                            @if(!empty($bisa_kp))
                            <dt>Tahapan Kerja Praktek</dt>
                            <dd>
                                @if($mahasiswa->tahapan_kp === 'lulus') <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                @else <span class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> {{ str_replace('_', ' ', $mahasiswa->tahapan_kp) }}</span>
                                @endif  
                            </dd>
                            @endif
                        @endif

                            <dt>Tahapan Skripsi</dt>
                            <dd>
                                @if($mahasiswa->tahapan_skripsi === 'lulus') <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                @else <span class="text-dark text-capitalize"><i class="fa fa-hourglass-half"></i> {{ str_replace('_', ' ', $mahasiswa->tahapan_skripsi) }}</span>
                                @endif  
                            </dd>

                            <dt>Dosen Pembimbing Skripsi</dt>
                            <dd>
                                @if(!blank($mahasiswa->dosenPembimbingSkripsi))
                                    1). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                    2). {{ !empty($mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }}
                                @else
                                    - 
                                @endif  
                            </dd>

                            @if(!empty($bisa_kp))
                            <dt>Dosen Pembimbing Kerja Praktek</dt>
                            <dd>
                                @if(!blank($mahasiswa->dosenPembimbingKp))
                                    1). {{ !empty($mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ? $mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                    2). {{ !empty($mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ? $mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }}
                                @else
                                    - 
                                @endif  
                            </dd>
                            @endif

                        </dl>
                    </div>
                </div>

                    <!-- riwayat tahapan skripsi dan kerja praktek -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="rt">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatTahapan"><span class="fa fa-history"></span> Riwayat Tahapan Skripsi & Kerja Praktek </button>
                            <div id="riwayatTahapan" class="collapse my-2 pb-1" data-parent="#rt">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <div class="table-responsive text-nowrap">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">No</th>
                                                    <th class="text-center align-middle">Tahapan</th>
                                                    <th class="text-center align-middle">Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1 ?>
                                            @foreach($mahasiswa->RiwayatTahapan as $riwayat)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="align-middle text-capitalize"> {{ str_replace('_', ' ', $riwayat->tahapan) }} </td>
                                                    <td class="align-middle">{{ selisih_waktu($riwayat->created_at) }}</td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat bimbingan -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="rb">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatBimbingan"><span class="fa fa-history"></span> Riwayat Progres Bimbingan </button>
                            <div id="riwayatBimbingan" class="collapse my-2 pb-1" data-parent="#rb">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <div class="table-responsive text-nowrap">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">No</th>
                                                    <th class="text-center align-middle">Dosen</th>
                                                    <th class="text-center align-middle">Ujian</th>
                                                    <th class="text-center align-middle">Konsultasi</th>
                                                    <th class="text-center align-middle">Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1 ?>
                                            @foreach($mahasiswa->bimbingan as $bimbingan)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="align-middle">{{ $bimbingan->dosen->nama }} </td>
                                                    <td class="align-middle text-center text-capitalize"> {{ str_replace('-', ' ', $bimbingan->bimbingan) }} </td>
                                                    <td class="align-middle text-capitalize"> {{ $bimbingan->konsultasi }} </td>
                                                    <td class="align-middle">{{ selisih_waktu($bimbingan->waktu) }}</td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat asistensi -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="rb">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatAsistensi"><span class="fa fa-history"></span> Riwayat Asistensi </button>
                            <div id="riwayatAsistensi" class="collapse my-2 pb-1" data-parent="#rb">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <div class="table-responsive text-nowrap">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">No</th>
                                                    <th class="text-center align-middle">Dosen</th>
                                                    <th class="text-center align-middle">Jenis Ujian</th>
                                                    <th class="text-center align-middle">Topik Bimbingan</th>
                                                    <th class="text-center align-middle">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1 ?>
                                            @foreach($mahasiswa->asistensi as $asistensi)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="align-middle">{{ $asistensi->dosen->nama }} </td>
                                                    <td class="align-middle text-capitalize"> {{ str_replace('-', ' ', $asistensi->jenis) }} </td>
                                                    <td class="align-middle"> {{ $asistensi->topik_bimbingan }} </td>
                                                    <td class="align-middle">{{ $asistensi->detailAsistensi->count() }}</td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat pendaftaran usulan topik -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="usulan">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#usulanTopik"><span class="fa fa-history"></span> Riwayat Pendaftaran Usulan Topik </button>
                            <div id="usulanTopik" class="collapse my-2 pb-1" data-parent="#usulan">
                                <div class="card">
                                    <div class="card-body m-0">
                                    <?php $i=1 ?>
                                    @foreach($mahasiswa->pendaftarUsulanTopik as $usulan_topik)
                                        <h6 class="font-weight-bold">Usulan Topik ke-{{ $i }}</h6>
                                        <dl>
                                            <dt>Usulan Judul</dt>
                                            <dd>{{ $usulan_topik->usulan_judul }}</dd>

                                            <dt>Usulan Topik</dt>
                                            <dd>{{ $usulan_topik->usulan_topik }}</dd>

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
                            
                                            <dt>Keterangan Validasi oleh Admin</dt>
                                            <dd class="text-dark">{{ $usulan_topik->keterangan }}</dd>
                                        </dl>
                                        <br>
                                    <?php $i++ ?>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat pendaftaran ujian -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="ujian">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatUjian"><span class="fa fa-history"></span> Riwayat Pendaftaran Ujian </button>
                            <div id="riwayatUjian" class="collapse my-2 pb-1" data-parent="#ujian">
                                <div class="card">
                                    <div class="card-body m-0">
                                    <?php $i=1 ?>
                                    @foreach($mahasiswa->pendaftarUjian as $pendaftar)
                                    <p class="card-title font-weight-bold text-capitalize my-0 py-0">{{ $i }}). {{ str_replace('-', ' ', $pendaftar->ujian) }}</p>
                                        <p class="my-0 py-0 text-capitalize text-truncate">
                                        @if($pendaftar->tahapan === 'diperiksa')
                                            <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                        @elseif($pendaftar->tahapan === 'diterima')
                                            <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                        @elseif($pendaftar->tahapan === 'ditolak')
                                            <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                        @elseif($pendaftar->tahapan === 'dibatalkan')
                                            <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                        @endif
                                        <br>
                                        <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                                    </p>
                                    <?php $i++ ?>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat pendaftaran turun KP -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="ujian">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatTurunKp"><span class="fa fa-history"></span> Riwayat Pendaftaran Turun KP </button>
                            <div id="riwayatTurunKp" class="collapse my-2 pb-1" data-parent="#ujian">
                                <div class="card">
                                    <div class="card-body m-0">
                                    <?php $i=1 ?>
                                    @foreach($mahasiswa->pendaftarTurunKp as $pendaftar)
                                    <p class="card-title font-weight-bold text-capitalize my-0 py-0">{{ $i }}). {{ $pendaftar->instansi }}</p>
                                        <p class="my-0 py-0 text-capitalize text-truncate">
                                        @if($pendaftar->tahapan === 'diperiksa')
                                            <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa</span>
                                        @elseif($pendaftar->tahapan === 'diterima')
                                            <span class="text-primary"><i class="fa fa-check"></i> Diterima</span>
                                        @elseif($pendaftar->tahapan === 'ditolak')
                                            <span class="text-danger"><i class="fa fa-times"></i> Ditolak</span>
                                        @elseif($pendaftar->tahapan === 'dibatalkan')
                                            <span class="text-warning"><i class="fa fa-ban"></i> Dibatalkan</span>
                                        @endif
                                        <br>
                                        <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                                    </p>
                                    <?php $i++ ?>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>

                    <!-- riwayat jadwal ujian -->
                    <div class="col-12 my-3 mx-0 px-0">
                        <div class="accordion mb-2 d-block mx-0 px-0" id="jadwal">
                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#riwayatJadwal"><span class="fa fa-history"></span> Riwayat Jadwal Ujian </button>
                            <div id="riwayatJadwal" class="collapse my-2 pb-1" data-parent="#jadwal">
                                <div class="card">
                                    <div class="card-body m-0">
                                        <div class="table-responsive text-nowrap">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">No</th>
                                                    <th class="text-center align-middle">Ujian</th>
                                                    <th class="text-center align-middle">Tempat & Waktu</th>
                                                    <th class="text-center align-middle">Dosen Penguji</th>
                                                    <th class="text-center align-middle">Peserta Ujian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1 ?>
                                                @foreach($mahasiswa->jadwalUjian as $jadwal)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $jadwal->ujian) }}</td>
                                                    <td class="align-middle">
                                                        {{ $jadwal->tempat }} <br> Hari {{ tanggal($jadwal->waktu_mulai) }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
                                                    <td class="align-middle">
                                                        @foreach($jadwal->dosenPenguji as $penguji)
                                                            {{ $penguji->dospeng }}). {{ $penguji->dosen->nama }} <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="align-middle">
                                                        <?php $k=1 ?>
                                                        @foreach($jadwal->pesertaUjian as $peserta)
                                                            {{ $k++ }}. {{ $peserta->mahasiswa->nama }} <br>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach                                    
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
@stop