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
        <h6 class="text-center font-weight-bold"> <u>BERITA ACARA SEMINAR KERJA PRAKTEK</u> </h6>
        <h6 class="text-center font-weight-bold"> Nomor: {{ $nomor }}</h6>
        <p class="mb-0 pb-0 px-2 mt-1">
            Pada hari ini {{ tanggal($jadwal->waktu_mulai) }} Telah Dilaksanakan Ujian Seminar Kerja Praktek bagi mahasiswa berikut :<br>
        </p>
        <table class="table borderless mb-0 pb-0">
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
                <td>Nama Instansi</td>
                <td>: {{ !empty($pendaftar->instansi) ? $pendaftar->instansi : $dosbing->lokasi }}</td>
            </tr>
        </table>
        <p class="my-0 py-0">Dengan Komponen Penilaian Sebagai Berikut</p>
        <table class="table table-bordered my-0 py-0">
        <tr class="nilai">
            <td class="font-weight-bold text-center align-middle" rowspan="2">Komponen</td>
            <td class="font-weight-bold text-center align-middle" rowspan="2">Bobot (%)</td>
            <td class="font-weight-bold text-center align-middle" colspan="2">Rata-Rata Nilai</td>
        </tr>
        <tr class="nilai">
            <td class="font-weight-bold text-center align-middle">Mahasiswa</td>
        </tr>
        @foreach($daftar_indikator as $indikator)
        <tr class="nilai">
            <td>{{ ucwords($indikator->nama) }}</td>
            <td class="text-center">{{ $indikator->bobot }}%</td>
            <td>&nbsp;</td>
        </tr>
        @endforeach
        <tr class="nilai">
            <td class="text-center align-middle font-weight-bold" colspan="2">TOTAL NILAI</td>
            <td class="text-center">&nbsp;</td>
        </tr>
        <tr class="nilai">
            <td class="text-center align-middle font-weight-bold" colspan="2">GRADE</td>
            <td class="text-center">&nbsp;</td>
        </tr>
    </table>
    
    <p class="my-0 py-0">
        Berdasarkan hasil seminar, maka dinyatakan : <strong>
            LULUS / TIDAK LULUS
        </strong> dengan Total Nilai .&nbsp;.&nbsp;.&nbsp; dan Grade .&nbsp;.&nbsp;.&nbsp;
    </p>
        
        <?php $i=1 ?>
        @foreach($dospeng as $dosenPenguji)
                <div class="float-left mx-5 px-3">
                <p>&nbsp;&nbsp; Penguji {{ $i }}</p>
                <br> <br> <br>
                <p style="font-size:10px;">(........................................) </p>
            </div>
        <?php $i++ ?>
        @endforeach

</body>
</html>