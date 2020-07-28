@extends('template')
@section('main')
                @include('errors.form_error')

                <!-- Filter pencarian -->
                <div class="accordion mb-2 d-none d-lg-inline" id="filter">
                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="button" data-toggle="collapse" data-target="#pencarian"><span class="fa fa-search"></span> Cari </button>
                    
                    @if(Request::segment(3) === 'cari')
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary show" data-parent="#filter">
                    @else
                    <div id="pencarian" class="collapse my-2 pb-1 border-bottom border-secondary" data-parent="#filter">
                    @endif
                        {!! Form::open(['url' => 'nilai-ujian/kerja-praktek/cari', 'method' => 'get']) !!}
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="">Nama</label>
                                    {!! Form::text('nama', (!empty($nama) ? $nama : null), ['class' => 'form-control']) !!}
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
                        
                            <div class="form-row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><span class="fa fa-search"></span> Cari</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <p class="mb-2">Total Data: <strong >{{ $total }}</strong><br></p>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Nilai Skripsi</strong>
                    </div>

                    <?php $i=1 ?>
                    @foreach($daftar_nilai_kp as $nilai)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($nilai->mahasiswa->nama) ? $nilai->mahasiswa->nama : '-' }} ({{ !empty($nilai->mahasiswa->nim) ? $nilai->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0">
                                    {{ !empty($nilai->mahasiswa->prodi->nama) ? $nilai->mahasiswa->prodi->nama : '-' }} ({{ !empty($nilai->mahasiswa->angkatan) ? $nilai->mahasiswa->angkatan : '-' }}) <br>
                                    Total Nilai: {{ !empty($nilai->nilaiUjianKp->last()->total) ? $nilai->nilaiUjianKp->last()->total : '-' }} 
                                    <br>
                                    Nilai Huruf: {{ !empty($nilai->nilaiUjianKp->last()->nilai_huruf) ? $nilai->nilaiUjianKp->last()->nilai_huruf : '-' }} 
                                    <br> 
                                    @if($nilai->nilaiUjianKp->last()->status === 'lulus')
                                        <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                    @else
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Lulus</span>
                                    @endif
                                    <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('nilai-ujian/'.$nilai->id.'/detail') }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>    
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('nilai-ujian/'.$nilai->id.'/detail') }}">
                                    <span class="fa fa-info-circle fa-lg"></span>&nbsp; Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_nilai_kp->onEachSide(1)->links() }}
                </nav>
@stop