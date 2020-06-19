@extends('template')
@section('main')
<div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header">
                                    <div class="float-left">
                                        <h4 class="card-title"> Detail Bimbingan {{ $bimbingan->mahasiswa->nama }}</h4>
                                    </div>

                                    <div class="float-right">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-simple" rel="tooltip" title="Kembali"> <i class="fa fa-arrow-left fa-lg"></i> </a>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Nama </th>
                                            <td>{{ $bimbingan->mahasiswa->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM </th>
                                            <td>{{ $bimbingan->mahasiswa->nim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Bimbingan Proposal</th>
                                            <td>{{ $total_proposal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Bimbingan Hasil</th>
                                            <td>{{ $total_hasil }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Bimbingan Sidang Skripsi</th>
                                            <td>{{ $total_sidang_skripsi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Bimbingan Kerja Praktek</th>
                                            <td>{{ $total_kp }}</td>
                                        </tr>
                                    </table>

                                    <h4>Riwayat Bimbingan</h4>

<!-- Riwayat Bimbingan -->
<div class="accordion" id="accordionExample">
  
<!-- Bimbingan Proposal -->
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="m-0">
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseOne">
          Bimbingan Proposal
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
      <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>No. </th>
                    <th>Dosen </th>
                    <th>Waktu </th>
                    <th>Konsultasi </th>
                </tr>

                <?php $i=1 ?>
                @foreach($daftar_bimbingan_proposal as $proposal)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $proposal->dosen->nama }}</td>
                    <td>{{ $proposal->waktu->formatLocalized("%A, %d %B %Y") }}</td>
                    <td>{{ $proposal->konsultasi }}</td>
                </tr>
                @endforeach
            </table>
      </div>
    </div>
  </div>

<!-- Bimbingan Hasil -->
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="m-0">
        <button class="btn btn-primary collapsed btn-sm" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Bimbingan Hasil
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-striped">
                <tr>
                    <th>No. </th>
                    <th>Dosen </th>
                    <th>Waktu </th>
                    <th>Konsultasi </th>
                </tr>

                <?php $i=1 ?>
                @foreach($daftar_bimbingan_hasil as $hasil)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $hasil->dosen->nama }}</td>
                    <td>{{ $hasil->waktu->formatLocalized("%A, %d %B %Y") }}</td>
                    <td>{{ $hasil->konsultasi }}</td>
                </tr>
                @endforeach
            </table>
      </div>
    </div>
  </div>

<!-- Bimbingan Sidang Skripsi -->
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="m-0">
        <button class="btn btn-primary collapsed btn-sm" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Bimbingan Sidang Skripsi
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-striped">
                <tr>
                    <th>No. </th>
                    <th>Dosen </th>
                    <th>Waktu </th>
                    <th>Konsultasi </th>
                </tr>

                <?php $i=1 ?>
                @foreach($daftar_bimbingan_sidang_skripsi as $sidang)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $sidang->dosen->nama }}</td>
                    <td>{{ $sidang->waktu->formatLocalized("%A, %d %B %Y") }}</td>
                    <td>{{ $sidang->konsultasi }}</td>
                </tr>
                @endforeach
            </table>
      </div>
    </div>
  </div>
  
<!-- Bimbingan Kerja Praktek -->
  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="m-0">
        <button class="btn btn-primary collapsed btn-sm" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
          Bimbingan Kerja Praktek
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
        <table class="table table-striped">
                <tr>
                    <th>No. </th>
                    <th>Dosen </th>
                    <th>Waktu </th>
                    <th>Konsultasi </th>
                </tr>

                <?php $i=1 ?>
                @foreach($daftar_bimbingan_kp as $kp)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $kp->dosen->nama }}</td>
                    <td>{{ $kp->waktu->formatLocalized("%A, %d %B %Y") }}</td>
                    <td>{{ $kp->konsultasi }}</td>
                </tr>
                @endforeach
            </table>
      </div>
    </div>
  </div>
  
</div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@stop