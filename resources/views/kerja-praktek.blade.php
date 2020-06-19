@extends('template-masuk')
@section('main-masuk')
    <div class="col-12 col-lg-9 my-2">

                <p class="mb-2">Total Data: <strong>{{ $total }}</strong><br></p>

                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span
                            class="fa fa-university"></span>
                        Pendaftar Turun Kerja Praktek {{ !empty($periode_aktif->nama) ? $periode_aktif->nama : '-' }}</h6>

                    <!-- jika data ada -->
                    @if(!blank($daftar_pendaftar))
                    <?php $i=1 ?>
                    @foreach($daftar_pendaftar as $pendaftar)
                    <div class="card-body border-bottom py-2 text-truncate">
                        <strong class="card-title">{{ $i }}). {{ !empty($pendaftar->mahasiswa->nama) ? $pendaftar->mahasiswa->nama : '-' }} ({{ !empty($pendaftar->mahasiswa->nim) ? $pendaftar->mahasiswa->nim : '-' }})</strong><br>
                        {{ $pendaftar->instansi }} <br>
                        <small> {{ $pendaftar->alamat }}</small> 
                        
                        @if($pendaftar->tahapan === 'ditolak')
                        <br> <span class="text-danger"> <i class="fa fa-ban"></i> Ditolak </span>
                        @elseif($pendaftar->tahapan === 'diterima')
                        <br> <span class="text-primary"> <i class="fa fa-check"></i> Diterima </span>
                        @elseif($pendaftar->tahapan === 'diperiksa')
                        <br> <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Diperiksa </span>
                        @endif
                        
                        <br> <span class="small"><em>({{ selisih_waktu($pendaftar->created_at) }})</em></span>
                        
                        <ul class="nav nav-pills nav-justified">
                            
                            <li class="nav-item mx-0 px-0">
                                <a class="nav-link text-info mx-0 px-0 small" href="{{ url('masuk/kerja-praktek/' . $pendaftar->id) }}"><span
                                        class="fa fa-info-circle"></span>&nbsp;
                                    Detail</a></li>
                            </li>
                            
                        </ul>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                    <!-- jika data kosong -->
                    @else
                    <div class="card-body border-bottom">
                        <h6 class="card-title text-center"> <span class="fa fa-info-circle"></span> Belum ada data</h6>
                    </div>
                    @endif
                </div>

                @if(!blank($daftar_pendaftar))
                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_pendaftar->onEachSide(1)->links() }}
                </nav>
                @endif
                
            </div>
@stop