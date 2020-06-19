<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <style>
        *{
            font-family: 'Times New Roman', serif;
        }
        img{
            width: 125px;
            position: absolute;
            top:25px;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
        <!-- KOP SURAT -->
        <img src="{{ asset('assets/images/UNG.png') }}">
        <h5 class="d-block text-center">
        KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN <br>
        UNIVERSITAS NEGERI GORONTALO <br>
        FAKULTAS TEKNIK <br> JURUSAN TEKNIK INFORMATIKA <br>
        </h5>
        <h6 class="d-block text-center" style="border-bottom: 2px solid black; padding-bottom:10px">
        Jl. B.J. Habibie, Desa Moutong, Kec. Tilongkabila, Kab. Bone Bolango <br>
        Telepon (0435) 821152 Faksimilie (0435) 821752 <br>
        Laman <u>https://ung.ac.id</u> <br>
        </h6>

        <br>
        <h5 class="text-center"> <u>SURAT PENUNJUKAN</u></h5>
        <br>
        <p>Dalam rangka Pembimbingan Penyusunan Laporan Kerja Praktek Mahasiswa Semester {{ $semester->nama }}, maka Ketua Jurusan Teknik Informatika Fakultas Teknik Universitas Negeri Gorontalo menunjuk nama-nama terlampir sebagai Pembimbing Penyusunan Laporan Kerja Praktek.</p>
        <p>Demikian surat penunjukan ini diberikan kepada yang bersangkutan untuk pelaksanaannya.</p>
        <br><br>
        <div class="float-right">
            <p>Gorontalo, {{ tanggal(now()) }} <br>
             <strong>Ketua Jurusan</strong> </p>
            <br> <br>
            <small><u>{{ $kajur->dosen->nama }}</u> <br>
            NIP: {{ $kajur->dosen->nip }}</small>
        </div>

        <div class="page_break"></div>

        <!-- LAMPIRAN -->

        <h5> <u>DAFTAR PEMBIMBINGAN PENYUSUNAN LAPORAN KERJA PRAKTEK
        <br> SEMESTER {{ strtoupper($semester->nama) }}
        </u></h5>
        <br>
        <table class="table table-bordered table-striped table-sm">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">NAMA & NIM</th>
                <th class="text-center">PEMBIMBING</th>
                <th class="text-center">LOKASI</th>
            </tr>
            <?php $i=1; $j=1 ?>
            @foreach($daftar_dosbing as $dosbing)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $dosbing->mahasiswa->nama }} <br> {{ $dosbing->mahasiswa->nim }}</td>
                <td>{{ $j++ }}). {{ $dosbing->dosbingSatuKp->nama }} <br> {{ $j }}). {{ $dosbing->dosbingDuaKp->nama }}</td>
                <td>{{ $dosbing->lokasi }}</td>
            </tr>
            <?php $j=1 ?>
            @endforeach
        </table>

        <br><br>
        <div class="float-right">
            <p><strong>Ketua Jurusan</strong> </p>
            <br> <br>
            <small><u>{{ $kajur->dosen->nama }}</u> <br>
            NIP: {{ $kajur->dosen->nip }}</small>
        </div>
        
</body>
</html>