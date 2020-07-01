@extends('template')
@section('main')
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Peserta Seminar</strong>
                        <a class="text-white" href="{{ url('peserta-ujian/lama/'.$mahasiswa->id) }}"><span class="fa fa-plus"></span> <span class="d-none d-lg-inline">Tambah</span></a>
                    </div>
                    
                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Nama & NIM</th>
                                        <th class="text-center align-middle">Ujian</th>
                                        <th class="text-center align-middle">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta_ujian as $peserta)
                                    <tr>
                                        <td class="text-left align-middle">{{ $peserta->jadwalUjian->mahasiswa->nama }} <br> {{ $peserta->jadwalUjian->mahasiswa->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $peserta->jadwalUjian->ujian) }}</td>
                                        <td class="align-middle">{{ tanggal($peserta->jadwalUjian->waktu_mulai) }}</td>
                                    </tr>
                                    @endforeach

                                    @foreach($peserta_ujian_lama as $peserta)
                                    <tr>
                                        <td class="align-middle text-left">{{ $peserta->nama }} <br> {{ $peserta->nim }}</td>
                                        <td class="text-center align-middle text-capitalize">{{ str_replace('-', ' ', $peserta->ujian) }}</td>
                                        <td class="align-middle">{{ tanggal($peserta->tanggal) }}</td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                    
                </div>
@stop