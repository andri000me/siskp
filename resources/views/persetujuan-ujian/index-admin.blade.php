@extends('template')
@section('main')
                <!-- total & menu opsional -->
                <nav class="navbar mb-2 navbar-expand-lg navbar-light justify-content-between border mb-1 mx-0 mt-0 shadow-sm">
                    <a class="text-dark"><span class="">Total: {{ number_format($total, 0, ',', '.') }}</span></a>
                    
                </nav>

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Persetujuan Ujian</strong>
                    </div>

                <!-- jika data ada -->
                    <?php $i=1 ?>
                @foreach($daftar_persetujuan as $persetujuan)
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <p class="card-title font-weight-bold my-0 py-0">{{ $i }}). {{ $persetujuan->mahasiswa->nama }} ({{ $persetujuan->mahasiswa->nim }})</p>
                                <p class="my-0 py-0 text-capitalize">
                                    Ujian {{ str_replace('-', ' ', $persetujuan->ujian) }} <br>
                                    
                                    @if($persetujuan->status_dosbing_satu === 'belum-diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                    @elseif($persetujuan->status_dosbing_satu === 'disetujui')
                                        <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                    @elseif($persetujuan->status_dosbing_satu === 'tidak-disetujui')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                    @endif
                                    oleh {{ !empty($persetujuan->dosbingSatuAproval->nama) ? $persetujuan->dosbingSatuAproval->nama : '-' }} 
                                    <br>

                                    @if($persetujuan->status_dosbing_dua === 'belum-diperiksa')
                                        <span class="text-dark"> <i class="fa fa-hourglass-half"></i> Belum Diperiksa</span>
                                    @elseif($persetujuan->status_dosbing_dua === 'disetujui')
                                        <span class="text-primary"><i class="fa fa-check"></i> Disetujui</span>
                                    @elseif($persetujuan->status_dosbing_dua === 'tidak-disetujui')
                                        <span class="text-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                    @endif
                                    oleh {{ !empty($persetujuan->dosbingDuaAproval->nama) ? $persetujuan->dosbingDuaAproval->nama : '-' }}
                                    <br>
                                    <small><em>({{ selisih_waktu($persetujuan->created_at) }})</em></small>
                                </p>
                                
                            </div>
                            
                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach

                </div>

                <!-- paginasi -->
                <nav class="pagination pagination-sm my-2 text-truncate">
                    {{ $daftar_persetujuan->onEachSide(1)->links() }}
                </nav>
@stop