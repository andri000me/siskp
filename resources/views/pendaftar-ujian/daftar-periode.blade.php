@extends('template')
@section('main')
                <!-- total berkas yang belum divalidasi -->
                @if($total_berkas)
                <div class="alert alert-warning">
                    <strong><span class="fa fa-info-circle"></span> Info!</strong> 
                    <br> Anda Punya {{ $total_berkas }} Berkas Yang Harus Di Validasi
                </div>
                @endif

                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(5) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'pendaftaran/ujian/periode/'. $id .'/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Ujian</label>
                                    {!! Form::select('ujian', ['proposal' => 'Proposal', 'hasil' => 'Hasil', 'sidang-skripsi' => 'Sidang Skripsi', 'kerja-praktek' => 'Kerja Praktek'], !empty($ujian) ? $ujian : null, ['class' => 'custom-select', 'placeholder' => '-- Jenis Ujian --']) !!}
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Program Studi</label>
                                    {!! Form::select('id_prodi', $daftar_prodi, (!empty($id_prodi) ? $id_prodi : null), ['placeholder' => 'Program Studi', 'class' => 'custom-select']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">NIM</label>
                                    {!! Form::text('nim', (!empty($nim) ? $nim : null), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Angkatan</label>
                                    {!! Form::text('angkatan', (!empty($angkatan) ? $angkatan : null), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        
                            {!! Form::hidden('id_periode_daftar_ujian', $id) !!}

                            <div class="form-row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{ url('pendaftaran/ujian/periode/'. $id .'/export?' . 
                                    'nama=' . Request::get('nama') .
                                     '&ujian=' . Request::get('ujian') .
                                     '&id_prodi=' . Request::get('id_prodi') .
                                     '&nim=' . Request::get('nim') .
                                     '&angkatan=' . Request::get('angkatan') .
                                     '&id_periode_daftar_ujian=' . $id
                                     )  }}" target="_blank" class="btn btn-success btn-block btn-sm"> <i class="fa fa-file-excel"></i> <strong>Export .xls</strong> </a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ $total }}</span></a>
                    
                    <div class="dropdown dropleft">
                        <a class="text-dark dropdown-toggle caret-off" href="#" data-toggle="dropdown"><span class="fa fa-ellipsis-h"></span> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#setujui">Setujui Semua</a>
                            <a class="dropdown-item" href="{{ url('pendaftaran/ujian/' . $id . '/input-by-admin') }}">Input Pendaftar Ujian</a>
                        </div>
                    </div>
                </nav>

                <!-- modal setujui semua -->
                <div class="modal fade" id="setujui" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title"> <i class="fa fa-info"></i> Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body text-dark h6">
                                Yakin Menyetujui semua berkas pada periode ini ?
                            </div>
                            <div class="modal-footer">
                                {!! Form::open(['url' => 'pendaftaran/ujian/setujui-semua']) !!}
                                    {!! Form::hidden('id_periode_daftar_ujian', $id) !!}
                                    <button type="submit" class="btn btn-link btn-primary btn-sm text-light"><i class="fa fa-check"></i> Setujui</button>
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Pendaftar Ujian {{ $periode->nama }}</strong>
                        
                        <a class="text-white d-none d-lg-inline" href="{{ url()->previous() }}">
                            <span class="fa fa-arrow-left"></span> <span class="">Kembali</span>
                        </a>

                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_ujian as $pendaftar)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold text-truncate my-0 py-0">{{ $i }}). {{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0 text-capitalize text-truncate">
                                    {{ str_replace('-', ' ', $pendaftar->ujian) }} <br>
                                    
                                    @if($pendaftar->ujian !== 'kerja-praktek')
                                        Judul: {{ !empty($pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $pendaftar->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}<br>
                                    @else
                                        Instansi: {{ !empty($pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi) ? $pendaftar->mahasiswa->pendaftarTurunKp->last()->instansi : $pendaftar->mahasiswa->dosenPembimbingKp->last()->lokasi }}<br>
                                    @endif

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
                                    <span class="small"><em>{{ selisih_waktu($pendaftar->created_at) }}</em></span>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-info mx-0 px-0 small" href="{{ url('pendaftaran/ujian/'.$pendaftar->id) }}"><span
                                                    class="fa fa-info-circle"></span>&nbsp;
                                                Detail</a>
                                        </li>
                                        <li class="nav-item mx-0 px-0">
                                            <a class="nav-link text-secondary small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                                <span class="fa fa-cog"></span>&nbsp; Lainnya
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ url('pendaftaran/ujian/'.$pendaftar->id.'/create-jadwal') }}">Input Jadwal Ujian</a>
                                                <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}">Hapus</a>
                                            </div>
                                        </li>
                                </ul>
                            </div>

                            <!-- modal hapus -->
                            <div class="modal fade" id="modal{{ $i }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-light">
                                            <h5 class="modal-title"> <i class="fa fa-exclamation-triangle"></i> Peringatan</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body text-dark h6">
                                            Yakin menghapus data ini ? Data yang sudah dihapus tidak bisa dikembalikan.
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['url' => 'pendaftaran/ujian/'.$pendaftar->id ,                               'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-link btn-danger btn-sm text-light"><i class="fa fa-trash"></i> Hapus</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-link btn-secondary btn-sm text-light" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-dark small dropdown-toggle caret-off" href="#" data-toggle="dropdown">
                                    <span class="fa fa-bars fa-lg"></span>&nbsp;
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('pendaftaran/ujian/'.$pendaftar->id) }}">Detail</a>
                                    <a class="dropdown-item" href="{{ url('pendaftaran/ujian/'.$pendaftar->id.'/create-jadwal') }}">Input Jadwal Ujian</a>
                                    <a class="dropdown-item" style="cursor:pointer" data-toggle="modal" data-target="#modal{{ $i }}">Hapus</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_ujian->onEachSide(1)->links() }}
                </nav>
@stop