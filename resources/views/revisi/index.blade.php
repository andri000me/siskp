@extends('template')
@section('main')

                <div class="alert alert-warning">
                    <strong><span class="fa fa-info"></span> Penting!</strong> 
                    <br> Anda Belum Mengupload Revisi Laporan dan Jurnal Skripsi
                </div>

               <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Revisi Anda</strong>
                        
                        <a class="text-white" href="{{ url('revisi-skripsi/create') }}"><span class="fa fa-upload"></span> <span class="">Upload Revisi</span></a>
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