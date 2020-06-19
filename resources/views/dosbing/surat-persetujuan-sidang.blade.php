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
            border: none; padding-top:0; padding-bottom:0;
        }
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

        <!-- Header -->
        <br>
        <h5 class="text-center"><u> PERSETUJUAN MENGIKUTI UJIAN SIDANG SKRIPSI</u></h5>
        <br>
        <p>
            Dengan ini menyatakan bahwa mahasiswa sebagai berikut :<br>
        </p>
            <table class="table borderless">
            <tr>
                <td>Nama</td>
                <td>: {{ $dosbing->mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $dosbing->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $dosbing->mahasiswa->prodi->nama }}</td>
            </tr>
            <tr>
                <td>Judul Penelitian </td>
                <td>: {{ !empty($usulan_topik->usulan_judul) ? $usulan_topik->usulan_judul : ' ' }}</td>
            </tr>
        </table>
        
        <br>
        <p class="text-center"> Telah diperiksa dan disetujui untuk diajukan pada :</p>
        <h5 class="text-center"> SIDANG SKRIPSI</h5>
        <br>
        
        <div class="float-left">
            <p>Dosen Pembimbing 1</p>
            <br> <br>
            <small><u>{{ $dosbing->dosbingSatuSkripsi->nama }}</u> <br>
            NIP: {{ $dosbing->dosbingSatuSkripsi->nip }}</small>
        </div>

        <div class="float-right">
            <p> Dosen Pembimbing 2</p>
            <br> <br>
            <small><u>{{ $dosbing->dosbingDuaSkripsi->nama }}</u> <br>
            NIP: {{ $dosbing->dosbingDuaSkripsi->nip }}</small>
        </div>

</body>
</html>