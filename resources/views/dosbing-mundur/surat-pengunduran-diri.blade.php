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
        .borderless td, .borderless th {
            border: none;
        }
    </style>
</head>
<body>
        <!-- KOP SURAT -->
        <img src="{{ asset('assets/images/UNG.png') }}">
        <h5 class="d-block text-center">
        KEMENTERIAN RISET TEKNOLOGI DAN PENDIDIKAN TINGGI <br>
        UNIVERSITAS NEGERI GORONTALO <br>
        FAKULTAS TEKNIK <br>
        JURUSAN TEKNIK INFORMATIKA <br>
        </h5>
        <h6 class="d-block text-center" style="border-bottom: 2px solid black; padding-bottom:10px">
        Jl. B.J. Habibie, Desa Moutong, Kec. Tilongkabila, Kab. Bone Bolango<br>
        Telepon (0435) 821152 Faksimilie (0435) 821752 <br>
        Laman <u>https://ung.ac.id</u> <br>
        </h6>
        <br>
        <h5 class="text-center"> PERNYATAAN PENGUNDURAN DIRI <br> DOSEN PEMBIMBING {{ strtoupper($dosbing->ujian) }}</h5>
        <br>
        <p>Saya yang bertanda tangan di bawah ini menyatakan <strong>mengundurkan diri</strong> sebagai Dosen Pembimbing {{ strtoupper($dosbing->ujian) }} atas mahasiswa berikut :</p>
        
        <table class="table borderless">
            <tr>
                <th>Nama</th>
                <td>: {{ $dosbing->mahasiswa->nama }}</td>
            </tr>
            <tr>
                <th>NIM</th>
                <td>: {{ $dosbing->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td>: {{ !empty($dosbing->mahasiswa->prodi->nama) ? $dosbing->mahasiswa->prodi->nama : ' - ' }}</td>
            </tr>
            <tr>
                <th>Semester</th>
                <td>: {{ $dosbing->semester->nama }}</td>
            </tr>
        </table>
        <p>
            <strong> Alasan Pengunduran Diri :</strong> <br>
            {{ $dosbing->alasan }}
        </p>
        <br><br>
        <div class="float-right">
            <p>Gorontalo, {{ tanggal(now()) }} <br>
             Yang menyatakan, </p>
            <br> <br>
            <p> <strong><u>{{ $dosbing->dosen->nama }}</u></strong> <br>
            NIP: {{ $dosbing->dosen->nip }}</p>
        </div>

</body>
</html>