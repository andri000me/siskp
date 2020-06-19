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
        KEMENTERIAN RISET TEKNOLOGI DAN PENDIDIKAN TINGGI <br>
        UNIVERSITAS NEGERI GORONTALO <br>
        FAKULTAS TEKNIK <br>
        JURUSAN TEKNIK INFORMATIKA <br>
        </h5>
        <h6 class="d-block text-center" style="border-bottom: 2px solid black; padding-bottom:10px">
        Jl. B.J. Habibie, Desa Moutong, Kec. Tilongkabila, Kab. Bone Bolango <br>
        Telepon (0435) 821152 Faksimilie (0435) 821752 <br>
        Laman <u>https://ung.ac.id</u> <br>
        </h6>

        <!-- Header -->
        <br>
        <h5 class="text-center"><u>PERSETUJUAN MENGIKUTI UJIAN {{ strtoupper($persetujuan->ujian) }}</u></h5>
        <br>
        <p>
            Dengan ini dinyatakan bahwa mahasiswa berikut :<br>
        </p>
            <table class="table borderless">
            <tr>
                <td>Nama</td>
                <td>: {{ $persetujuan->mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $persetujuan->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $persetujuan->mahasiswa->prodi->nama }}</td>
            </tr>
            <tr>
                <td>Judul</td>
                @if($persetujuan->ujian !== 'kerja-praktek')
                <td>{{ !empty($judul->usulan_judul) ? $judul->usulan_judul : '' }}</td>
                @else
                <td>: ...............................&nbsp;...............................&nbsp;...............................&nbsp;...............................&nbsp;...............................&nbsp;...............................&nbsp;...............................&nbsp;...............................</td>
                @endif
            </tr>
        </table>
        <p class="text-center">Telah diperiksa dan disetujui untuk diajukan pada:</p>
        <h5 class="text-center">{{ strtoupper($persetujuan->ujian) }}</h5>
        <br>
            
            <div class="float-left">
                <p><br><br></p>
                <p> Pembimbing 1</p>
                @if(!empty($persetujuan->dosbingSatuAproval->tanda_tangan))
                    <img src="{{ asset('assets/ttd/' . $persetujuan->dosbingSatuAproval->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-5 mt-3">
                @endif
                <br> <br>
                <p style="font-size:12px;"> <u>{{ $persetujuan->dosbingSatuAproval->nama }}</u> <br>
                NIP: {{ $persetujuan->dosbingSatuAproval->nip }}</p>
            </div>

            <div class="float-right">
                <p>Gorontalo, {{ tanggal(now()) }} <br>Yang menyatakan, </p>
                <p>Pembimbing 2</p>
                @if(!empty($persetujuan->dosbingDuaAproval->tanda_tangan))
                    <img src="{{ asset('assets/ttd/' . $persetujuan->dosbingDuaAproval->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-5">
                @endif
                <br> <br>
                <p style="font-size:12px;"><u>{{ $persetujuan->dosbingDuaAproval->nama }}</u> <br>
                NIP: {{ $persetujuan->dosbingDuaAproval->nip }}</p>
            </div>

</body>
</html>