@extends('template')
@section('main')

                @if(!empty($pendaftar) && empty($riwayat))
                <div class="alert alert-danger">
                    <strong><span class="fa fa-exclamation-triangle"></span> Penting!</strong> 
                    <br> Anda telah selesai Ujian Sidang Skripsi tapi belum mengupload revisi laporan dan/atau Jurnal Skripsi
                </div>
                @else
                <div class="alert alert-info">
                    <strong><span class="fa fa-info-circle"></span> Info</strong> 
                    <br> Fitur ini hanya bisa digunakan jika anda telah selesai Ujian Sidang Skripsi tapi belum mengupload Laporan dan/atau Jurnal Skripsi yang sudah revisi
                </div>
                @endif

               <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Revisi</strong>
                        
                        @if(!empty($pendaftar) && !empty($riwayat))
                            <a class="text-white" href="{{ url('revisi-skripsi/create') }}"><span class="fa fa-upload"></span> <span class="">Edit Laporan & Jurnal</span></a>
                        @elseif(!empty($pendaftar))
                            <a class="text-white" href="{{ url('revisi-skripsi/create') }}"><span class="fa fa-upload"></span> <span class="">Upload Laporan & Jurnal</span></a>
                        @endif
                    </div>

                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>File Laporan Skripsi 
                            @if(isset($pendaftar->file_laporan))
                                <small><a href="{{ asset('assets/laporan/'.$pendaftar->file_laporan) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika jurnal ada -->
                            @if(isset($pendaftar->file_laporan))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/laporan/'.$pendaftar->file_laporan) }}" type="application/pdf">
                            </dd>
                            <!-- jika jurnal kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif

                            <dt>File Jurnal Skripsi 
                            @if(isset($riwayat->file_jurnal_skripsi))
                                <small><a href="{{ asset('assets/jurnal/' . $riwayat->file_jurnal_skripsi) }}">Download</a> </small> 
                            @endif
                            </dt>
                            <!-- Jika jurnal ada -->
                            @if(isset($riwayat->file_jurnal_skripsi))
                            <dd class="embed-responsive"  style="height: 75vh">
                                <embed src="{{ asset('assets/jurnal/' . $riwayat->file_jurnal_skripsi) }}" type="application/pdf">
                            </dd>
                            <!-- jika jurnal kosong -->
                            @else
                            <dd><span class="fa fa-info-circle"></span> Belum ada data</dd>
                            @endif

                        </dl>
                    </div>

                </div>
@stop