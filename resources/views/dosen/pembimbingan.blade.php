@extends('template')
@section('main')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Pendampingan Akademik</h4>
                                        <p class="card-category">Daftar Mahasiswa Pendampingan Akademik</p>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>NO</th>
                                            <th>NAMA</th>
                                            <th>NIM</th>
                                            <th>PROGRAM STUDI</th>
                                            <th>ANGKATAN</th>
                                            <th>AKSI</th>
                                        </thead>
                                        @if(!empty($daftar_pa))
                                        <tbody>
                                            <?php $i=1 ?>
                                            @foreach($daftar_pa as $pa)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $pa->nama }} </td>
                                                <td> {{ $pa->nim }} </td>
                                                <td>{{ $pa->prodi->nama }}</td>
                                                <td>{{ $pa->angkatan }}</td>
                                                <td>
                                                    <a href="{{ url('mahasiswa/detail/'.$pa->id) }}" class="btn btn-info btn-simple d-block" rel="tooltip" title="Detail"><i class="fa fa-eye fa-lg"></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                
                            </div>
                        </div>

                        @if(!empty($daftar_pa))
                        <div class="col-md-12" class="text-center">
                            <nav aria-label="Page navigation">
                                {{ $daftar_pa->links() }}
                            </nav>
                        </div>
                        @endif

                        <!-- Mahasiswa Skripsi -->

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Pembimbingan Skripsi</h4>
                                        <p class="card-category">Daftar Mahasiswa Pembimbingan Skripsi</p>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>NO</th>
                                            <th>NAMA & NIM</th>
                                            <th>TAHAPAN SKRIPSI</th>
                                            <th>PEMBIMBING</th>
                                            <th>AKSI</th>
                                        </thead>
                                        @if(!empty($daftar_skripsi))
                                        <tbody>
                                            <?php $i=1 ?>
                                            @foreach($daftar_skripsi as $skripsi)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $skripsi->mahasiswa->nama }} <br> {{ $skripsi->mahasiswa->nim }} </td>
                                                <td>{{ strtoupper(str_replace('_', ' ', $skripsi->mahasiswa->tahapan_skripsi)) }}</td>
                                                <td>
                                                    {{ $skripsi->dosbingSatuSkripsi->nama ? 'UTAMA' : 'PENDAMPING' }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('mahasiswa/detail/'.$skripsi->mahasiswa->id) }}" class="btn btn-info btn-simple d-block" rel="tooltip" title="Detail"><i class="fa fa-eye fa-lg"></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                
                            </div>
                        </div>

                        @if(!empty($daftar_skripsi))
                        <div class="col-md-12" class="text-center">
                            <nav aria-label="Page navigation">
                                {{ $daftar_skripsi->links() }}
                            </nav>
                        </div>
                        @endif

                        <!-- Mahasiswa KP -->

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Pembimbingan Kerja Praktek</h4>
                                        <p class="card-category">Daftar Mahasiswa Pendampingan Kerja Praktek</p>
                                    </div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>NO</th>
                                            <th>NAMA & NIM</th>
                                            <th>TAHAPAN KERJA PRAKTEK</th>
                                            <th>PEMBIMBING</th>
                                            <th>AKSI</th>
                                        </thead>
                                        @if(!empty($daftar_kp))
                                        <tbody>
                                            <?php $i=1 ?>
                                            @foreach($daftar_kp as $kp)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $kp->mahasiswa->nama }} <br> {{ $kp->mahasiswa->nim }} </td>
                                                <td>{{ strtoupper(str_replace('_', ' ', $kp->mahasiswa->tahapan_kp)) }}</td>
                                                <td>
                                                    {{ $kp->dosbingSatuKp->nama ? 'UTAMA' : 'PENDAMPING' }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('mahasiswa/detail/'.$kp->mahasiswa->id) }}" class="btn btn-info btn-simple d-block" rel="tooltip" title="Detail"><i class="fa fa-eye fa-lg"></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                
                            </div>
                        </div>

                        @if(!empty($daftar_kp))
                        <div class="col-md-12" class="text-center">
                            <nav aria-label="Page navigation">
                                {{ $daftar_kp->links() }}
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
@stop