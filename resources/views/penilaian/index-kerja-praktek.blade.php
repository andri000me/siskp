@extends('template')
@section('main')
                @include('errors.form_error')

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
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ !empty($nilai->jadwalUjian->mahasiswa->nama) ? $nilai->jadwalUjian->mahasiswa->nama : '-' }} ({{ !empty($nilai->jadwalUjian->mahasiswa->nim) ? $nilai->jadwalUjian->mahasiswa->nim : '-' }})</p>
                                <p class="my-0 py-0">
                                    {{ !empty($nilai->jadwalUjian->mahasiswa->prodi->nama) ? $nilai->jadwalUjian->mahasiswa->prodi->nama : '-' }} ({{ !empty($nilai->jadwalUjian->mahasiswa->angkatan) ? $nilai->jadwalUjian->mahasiswa->angkatan : '-' }}) <br>
                                    Total Nilai: {{ !empty($nilai->total) ? $nilai->total : '-' }} 
                                    <br>
                                    Nilai Huruf: {{ !empty($nilai->nilai_huruf) ? $nilai->nilai_huruf : '-' }} 
                                    <br> 
                                    @if($nilai->status >= 'lulus')
                                        <span class="text-primary"><i class="fa fa-check"></i> Lulus</span>
                                    @else
                                        <span class="text-danger"><i class="fa fa-times"></i> Belum Lulus</span>
                                    @endif
                                    <br>
                                </p>

                                <!-- menu mobile -->
                                <ul class="nav nav-pills nav-justified d-lg-none">
                                    <li class="nav-item mx-0 px-0"><a class="nav-link text-info mx-0 px-0 small" href="{{ url('nilai-ujian/'.$nilai->id_jadwal_ujian.'/detail') }}"><span class="fa fa-info-circle"></span>&nbsp; Detail</a></li>    
                                </ul>
                            </div>

                            <!-- menu large -->
                            <div class="col-1 dropdown dropleft text-center d-none d-lg-flex justify-content-center align-items-center">
                                <a class="text-info small" href="{{ url('nilai-ujian/'.$nilai->id_jadwal_ujian.'/detail') }}">
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