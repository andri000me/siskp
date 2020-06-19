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
        <div class="float-left">
            <p>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $nomor }} <br>
            Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : UNDANGAN PENGUJI {{ strtoupper($jadwal->ujian) }} </p>
        </div>
        <div class="float-right">
            <p>{{ tanggal(now()) }}</p>
        </div>
        <div class="clearfix"></div>
        <p>
            Kepada Yth, <br>
            @foreach($jadwal->dosenPenguji as $penguji)
            <strong> {{ $penguji->dospeng }}. {{ $penguji->dosen->nama }} </strong> <br>
            @endforeach
            Di <br> &nbsp;&nbsp;&nbsp; Tempat <br> <br>

            <strong> <em>Assalamualaikum Wr. Wb.</em> </strong><br>
            Dengan Hormat, <br>
            Sehubungan dengan akan dilaksanakannya Ujian {{ $jadwal->ujian }} Mahasiswa Program Studi {{ $jadwal->mahasiswa->prodi->nama }}, maka dengan ini memohon kesediaan Bapak/Ibu untuk menjadi Penguji pada kegiatan tersebut yang Insha Allah akan dilaksanakan pada:<br>
        </p>
            <table class="table borderless">
            <tr>
                <td>Nama Peserta Ujian</td>
                <td>: {{ $jadwal->mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>Hari/Tanggal</td>
                <td>: {{ tanggal($jadwal->waktu_mulai) }}</td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>: Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>: {{ $jadwal->tempat }}</td>
            </tr>
            @if($jadwal->ujian !== 'kerja-praktek')
                <tr>
                    <td>Judul</td>
                    <td>: {{ $judul->usulan_judul }}</td>
                </tr>
            @else
                <tr>
                    <td>Instansi</td>
                    <td>: {{ !empty($pendaftar_kp->instansi) ? $pendaftar_kp->instansi : $dosbing->lokasi }}</td>
                </tr>
            @endif
            
            @if($jadwal->ujian !== 'kerja-praktek')
                <tr>
                    <td>Dosen Pembimbing</td>
                    <td>: 1). {{ $dosbing->dosbingSatuSkripsi->nama }} <br> 2). {{ $dosbing->dosbingDuaSkripsi->nama }}</td>
                </tr>
            @else
                <tr>
                    <td>Dosen Pembimbing</td>
                    <td>: 1). {{ $dosbing->dosbingSatuKp->nama }} <br> 2). {{ $dosbing->dosbingDuaKp->nama }}</td>
                </tr>
            @endif
        </table>
        <p>
        Atas waktu dan perhatiannya kami ucapkan terima kasih. <br>
        <strong> <em>Wassalamualaikum Wr. Wb.</em> </strong>
        </p>

</body>
</html>