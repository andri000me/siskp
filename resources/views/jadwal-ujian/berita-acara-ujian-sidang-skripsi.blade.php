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
        <h6 class="text-center font-weight-bold"> <u>BERITA ACARA SIDANG SKRIPSI</u> </h6>
        <h6 class="text-center font-weight-bold"> Nomor: {{ $nomor }}</h6>
        <p class="mb-0 px-3 pb-0">
            Pada hari ini {{ tanggal($jadwal->waktu_mulai) }} Telah Dilaksanakan Ujian Sidang Skripsi bagi mahasiswa berikut :<br>
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
                <td>Judul Skripsi</td>
                <td>: {{ $judul->usulan_judul }}</td>
            </tr>
        </table>
        <table class="table table-bordered mb-0 pb-0">
        <tr class="nilai">
            <th class="text-center align-middle" rowspan="2">Indikator Penilaian</th>
            <th class="text-center align-middle" rowspan="2">Bobot (%)</th>
            <th class="text-center align-middle" colspan="4">Nilai Skor Penguji</th>
            <th class="text-center align-middle" rowspan="2">Rata-Rata</th>
            <th class="text-center align-middle" rowspan="2">Bobot x Rata-Rata Skor</th>
        </tr>
        <tr class="nilai">
            <th class="text-center align-middle">1</th>
            <th class="text-center align-middle">2</th>
            <th class="text-center align-middle">3</th>
            <th class="text-center align-middle">4</th>
        </tr>
        @foreach($daftar_indikator as $indikator)
        <tr class="nilai">
            <td>{{ ucwords($indikator->nama) }}</td>
            <td class="text-center align-middle">{{ $indikator->bobot }}</td>
            <td class="text-center align-middle"> </td>
            <td class="text-center align-middle"> </td>
            <td class="text-center align-middle"> </td>
            <td class="text-center align-middle"> </td>
            <td class="text-center align-middle"> </td>
            <td class="text-center align-middle"> </td>
        </tr>
        @endforeach
        <tr class="nilai">
            <th colspan="7" class="text-right">Jumlah Nilai</th>
            <td> </td>
        </tr>
        <tr class="nilai">
            <th colspan="7" class="text-right">Nilai Akhir Ujian Sidang Skripsi : (Jumlah Nilai / 500) * 100</th>
            <td> </td>
        </tr>
    </table>
        <p class="py-0 my-0">Nilai Akhir Sidang Skripsi, selanjutnya diakumulasi dengan Nilai Seminar Proposal dan Nilai Seminar Hasil Skripsi untuk menentukan kelulusan.</p>

        <div class="page_break"></div>

        <h6 class="text-center"> HASIL AKUMULASI PEROLEHAN NILAI:</h6>
        <table class="table table-bordered table-striped">
            <tr>
                <th class="text-center">Jenis Penilaian </th>
                <th class="text-center">Bobot (%)</th>
                <th class="text-center">Nilai</th>
                <th class="text-center">Bobot (%) x Nilai</th>
            </tr>
            <tr>
                <td class="text-center">Seminar Proposal </td>
                <td class="text-center">25</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">Seminar Hasil </td>
                <td class="text-center">25</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">Sidang Skripsi </td>
                <td class="text-center">50</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Total (Nilai Angka)</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Nilai Huruf</th>
                <th></th>
            </tr>
        </table>

        <p class="text-center">Berdasarkan hasil akumulasi perolehan nilai, maka mahasiswa tersebut dinyatakan :</p>
        <br><br>
        <h3 class="text-center"><strong>LULUS / TIDAK LULUS</strong></h3>
        <br><br>

        @foreach($jadwal->dosenPenguji as $penguji)
            @if($jadwal->dosenPenguji->count() === 4)
                <div class="float-left mx-4">
            @elseif($jadwal->dosenPenguji->count() === 5)
                <div class="float-left mx-3">
            @endif
                <p>Penguji {{ $penguji->dospeng }}</p>
                <br> <br>
                <strong>(..........................)</strong>
            </div>
        @endforeach
</body>
</html>