@extends('template')
@section('main')
                @include('errors.form_error')

                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light text-capitalize">{{ $asistensi->topik_bimbingan }}</strong>
                        
                        @if(Session::has('dosen') || Session::has('mahasiswa'))
                        <a class="text-white" href="{{ url('asistensi/' . $asistensi->id . '/tambah-komentar') }}"><span class="fa fa-comments"></span> <span class="d-none d-lg-inline">Komentar</span></a>
                        @endif
                    </div>
                </div>
                
                @foreach($detail_asistensi as $detail)
                <div class="card mb-2">
                    <div class="card-body border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-11 mx-0 px-0">
                                <p class="card-title">
                                @if($detail->is_mahasiswa)
                                    <strong class="text-dark">{{ !empty($asistensi->mahasiswa->nama) ? $asistensi->mahasiswa->nama : '-' }} ({{ !empty($asistensi->mahasiswa->nim) ? $asistensi->mahasiswa->nim : '-' }}) </strong>
                                @elseif($detail->is_dosen)
                                    <strong class="text-dark">{{ $asistensi->dosen->nama }} </strong>
                                @endif
                                </p>
                                <p class="card-title my-0 py-0">{!! $detail->isi !!} </p>
                                <p class="my-0 py-0">
                                    @if($detail->file)
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item mx-0 px-0"><a class="nav-link text-secondary mx-0 px-0 small" target="_blank" href="{{ asset('assets/asistensi/' . $detail->file) }}"><span class="fa fa-download"></span>&nbsp; Unduh</a></li>
                                    </ul>
                                    @endif
                                </p>
                                <small><em>{{ selisih_waktu($detail->created_at) }}</em></small>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

                
@stop