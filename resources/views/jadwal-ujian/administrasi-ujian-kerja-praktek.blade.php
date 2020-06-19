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
        tr.nilai{
            line-height:17px;
        }
    </style>
</head>
<body>
        <!-- UNDANGAN PENGUJI UJIAN -->
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
        <div class="float-left">
            <p>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $nomor->nomor_undangan }} <br>
            Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Undangan Penguji Ujian {{ ucwords($jadwal->ujian) }} </p>
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
        
        <div class="float-right">
            <p>Gorontalo, {{ tanggal(now()) }}</p>
            <p>Ketua Program Studi,</p>
            <br>
            <small><u>{{ $kaprodi->dosen->nama }}</u><br>
            NIP: {{ $kaprodi->dosen->nip }}</small>
        </div>

        <div class="page_break"></div>
        
        
        
        
        
        <!-- lembar penilaian -->
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
        <h5 class="text-center"> LEMBAR PENILAIAN <br> UJIAN SEMINAR KERJA PRAKTEK</h5>
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
                <td>Judul</td>
                <td>: {{ $judul }}</td>
            </tr>
            <tr>
                <td>Dosen Pembimbing</td>
                <td>: 1). {{ $dosbing->dosbingSatuKp->nama }} <br> 2). {{ $dosbing->dosbingDuaKp->nama }}</td>
            </tr>
            <tr>
                <td>Nama Instansi</td>
                <td>: {{ !empty($pendaftar->instansi) ? $pendaftar->instansi : $dosbing->lokasi }}</td>
            </tr>
        </table>
        <p>ASPEK PENILAIAN: </p>
        <table class="table table-bordered">
        <tr class="nilai">
            <th class="text-center align-middle">KOMPONEN</th>
            <th class="text-center align-middle">BOBOT (%)</th>
            <th class="text-center align-middle">NILAI (0-100)</th>
            <th class="text-center align-middle">BOBOT x NILAI</th>
        </tr>
        @foreach($daftar_indikator as $indikator)
        <tr class="nilai">
            <th class="text-center align-middle">{{ ucwords($indikator->nama) }}</th>
            <th class="text-center align-middle">{{ $indikator->bobot }}%</th>
            <th class="text-center align-middle">&nbsp;</th>
            <th class="text-center align-middle">&nbsp;</th>
        </tr>
        @endforeach
        <tr class="nilai">
            <th class="text-center align-middle" colspan="3">TOTAL NILAI</th>
            <th class="text-center align-middle">&nbsp;</th>
        </tr>
    </table>
            <div class="float-right mx-3">
                <p>Penguji,</p>
                <br> <br>
                <strong>(..........................)</strong>
            </div>
        
        
        
        
        
        
        <!-- Halaman Lembar Revisi -->

        <div class="page_break"></div>

        <!-- Header -->
        <h5 class="text-center"> LEMBAR REVISI <br> UJIAN SEMINAR KERJA PRAKTEK</h5>
        <br>
        <table class="table borderless">
            <tr>
                <td>Nama & NIM</td>
                <td>: {{ $dosbing->mahasiswa->nama }} / {{ $dosbing->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $dosbing->mahasiswa->prodi->nama }}</td>
            </tr>
            <tr>
                <td>Judul</td>
                <td>: {{ $judul }}</td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td>: {{ !empty($pendaftar->instansi) ? $pendaftar->instansi : $dosbing->lokasi }}</td>
            </tr>
            <tr>
                <td>Materi Revisi</td>
                <td>:</td>
            </tr>
        </table>
        <div style="height: 650px; border:solid black 1px;"></div>
        <div class="float-right">
            <p>Moderator</p>
            <br> <br>
            <strong>(..........................)</strong>
        </div>

        <!-- Halaman Presensi Kehadiran -->

        <div class="page_break"></div>

        <!-- Header -->
        <h5 class="text-center"> PRESENSI KEHADIRAN <br> UJIAN SEMINAR KERJA PRAKTEK</h5>
        <br>
        <table class="table borderless">
            <tr>
                <td>Nama & NIM</td>
                <td>: {{ $dosbing->mahasiswa->nama }} / {{ $dosbing->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $dosbing->mahasiswa->prodi->nama }}</td>
            </tr>
            <tr>
                <td>Judul</td>
                <td>: {{ $judul }}</td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td>: {{ !empty($pendaftar->instansi) ? $pendaftar->instansi : $dosbing->lokasi }}</td>
            </tr>
            <tr>
                <td>Hari Tanggal</td>
                <td>: {{ tanggal($jadwal->waktu_mulai) }}</td>
            </tr>
            <tr>
                <td>Dosen Penguji</td>
                <td>:</td>
            </tr>
        </table>
        <table class="table borderless">
            <tr style="line-height:75px;">
                <th>Nama</th>
                <th>Tanda Tangan</th>
            </tr>
            @foreach($jadwal->dosenPenguji as $penguji)
            <tr style="line-height:75px;">
                <td>{{ $penguji->dospeng }}. {{ $penguji->dosen->nama }}</td>
                <td>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
            </tr>
            @endforeach
        </table>

</body>
</html>