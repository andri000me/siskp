@extends('template')
@section('main')
<div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Detail Jadwal Ujian</h4>
                                    </div>

                                    <div class="float-right">
                                        
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>

                                    </div>

                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Nama </td>
                                            <th>{{ $jadwal->mahasiswa->nama }}</th>
                                        </tr>
                                        <tr>
                                            <td>NIM </td>
                                            <th>{{ $jadwal->mahasiswa->nim }}</th>
                                        </tr>
                                        <tr>
                                            <td>Ujian</td>
                                            <th>{{ strtoupper($jadwal->ujian) }}</th>
                                        </tr>
                                        <tr>
                                            <td>Tempat</td>
                                            <th>{{ $jadwal->tempat }}</th>
                                        </tr>
                                        <tr>
                                            <td>Waktu Ujian</td>
                                            <th>{{ $jadwal->waktu_mulai->formatLocalized("%A, %d %B %Y %H:%M") }} - {{ $jadwal->waktu_selesai->formatLocalized("%H:%M") }} WITA</th>
                                        </tr>
                                    </table>

                                    <div class="float-left">
                                        <h4 class="card-title ml-3 mr-0"> Daftar Dosen Penguji</h4>
                                    </div>

                                    <table class="table">
                                        <tr>
                                            <th>Penguji</th>
                                            <th>Dosen</th>
                                        </tr>
                                        @foreach($jadwal->dosenPenguji as $penguji)
                                        <tr>
                                            <td>{{ $penguji->dospeng }}</td>
                                            <td>{{ $penguji->dosen->nama }}</td>
                                        </tr>
                                        @endforeach
                                    </table>

                                    <div class="float-left">
                                        <h4 class="card-title ml-3 mr-0"> Daftar Peserta Ujian</h4>
                                    </div>

                                    <table class="table">
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                        </tr>
                                        <?php $i=1 ?>
                                        @foreach($jadwal->pesertaUjian as $peserta)
                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            <td>{{ $peserta->mahasiswa->nim }}</td>
                                            <td>{{ $peserta->mahasiswa->nama }}</td>
                                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                            <td>
                                                <a href="#" class="btn btn-danger btn-simple d-block" data-toggle="modal" data-target="#modalMahasiswa{{ $i }}" rel="tooltip" title="Hapus"><i class="fa fa-trash fa-lg"></i> </a>
                                                        
                                                        <div class="modal fade modal-mini modal-primary" id="modalMahasiswa{{ $i++ }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header justify-content-center">
                                                                        <i class="fa text-danger fa-exclamation fa-4x"></i>
                                                                    </div>
                                                                <div class="modal-body text-center text-danger">
                                                                    <p>Apakah anda yakin menghapus data ini ?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {!! Form::open(['url' => 'peserta-ujian/'.$peserta->id , 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                                        <button type="submit" class="btn btn-danger btn-simple">Hapus</button>
                                                                    {!! Form::close() !!}
                                                                    <button type="button" class="btn btn-link btn-simple" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </table>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop