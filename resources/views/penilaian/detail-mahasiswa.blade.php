@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card mb-3">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span class="far fa-clock"></span> Nilai Ujian Skripsi Saya</h6>
                    
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Seminar Proposal</th>
                                        <th class="text-center align-middle">Seminar Hasil</th>
                                        <th class="text-center align-middle">Sidang Skripsi</th>
                                        <th class="text-center align-middle">Total Nilai</th>
                                        <th class="text-center align-middle">Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    @foreach($hasil_akumulasi_nilai as $nilai)
                                    <tr>
                                        <td class="text-center align-middle">{{ $nilai->seminar_proposal }} </td>
                                        <td class="text-center align-middle">{{ $nilai->seminar_hasil }}</td>
                                        <td class="text-center align-middle">{{ $nilai->sidang_skripsi }}</td>
                                        <td class="text-center align-middle">{{ $nilai->total }}</td> <?php $total = $nilai->total ?>
                                        <td class="text-center align-middle">{{ $nilai->nilai_huruf }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h6 class="text-center">Berdasarkan hasil akumulasi nilai, maka anda dinyatakan:</h6>
                                    <h5 class="text-center">
                                        @if($total >= 60)
                                            <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                        @else
                                            <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus</span>
                                        @endif
                                </h5>

                    </div>
                    
                </div>

                @if(Session::has('bisa_kp'))
                <div class="card">
                    <h6 class="card-header bg-primary font-weight-bold text-light"><span class="far fa-clock"></span> Nilai Ujian Kerja Praktek Saya</h6>
                    
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Total Nilai</th>
                                        <th class="text-center align-middle">Huruf</th>
                                        <th class="text-center align-middle">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilai_ujian_kp as $nilai)
                                    <tr>
                                        <td class="text-center">{{ $nilai->total }}</td>
                                        <td class="text-center">{{ $nilai->nilai_huruf }}</td>
                                        <td class="text-center d-block">
                                            @if($nilai->status === 'lulus')
                                                <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                            @else
                                                <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus</span>
                                            @endif                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    
                </div>
                @endif
@stop