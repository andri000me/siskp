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
        Jl. B.J. Habibie, Desa Moutong, Kec. Tilongkabila, Bone Bolango <br>
        Telepon (0435) 821152 Faksimilie (0435) 821752 <br>
        Laman <u>https://ung.ac.id</u> <br>
        </h6>

        <!-- Header -->
        <h6 class="text-center font-weight-bold"> <u>BERITA ACARA SIDANG SKRIPSI</u> </h6>
        <h6 class="text-center font-weight-bold" > Nomor: {{ $nomor }}</h6>
        <p class="mb-0 px-2 pb-0">
            Pada hari ini {{ tanggal($jadwal->waktu_mulai) }} Telah Dilaksanakan Ujian Sidang Skripsi bagi mahasiswa berikut :<br>
        </p>
            <table class="table borderless my-0 py-0">
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
        <table class="table table-bordered my-0 py-0">
        <tr class="nilai">
            <th class="text-center align-middle" rowspan="2">Indikator Penilaian</th>
            <th class="text-center align-middle" rowspan="2">Bobot (%)</th>
            <th class="text-center align-middle" colspan="5">Nilai Skor Penguji</th>
            <th class="text-center align-middle" rowspan="2">Rerata</th>
            <th class="text-center align-middle" rowspan="2">Bobot x Rerata Skor</th>
        </tr>
        <tr class="nilai">
            <th class="text-center align-middle">1</th>
            <th class="text-center align-middle">2</th>
            <th class="text-center align-middle">3</th>
            <th class="text-center align-middle">4</th>
            <th class="text-center align-middle">5</th>
        </tr>
        @foreach($penilaian_ujian as $penilaian)
        <tr class="nilai">
            <td>{{ ucwords($penilaian->indikatorPenilaian->nama) }}</td>
            <td class="text-center align-middle">{{ $penilaian->indikatorPenilaian->bobot }}%</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_satu }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_dua }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_tiga }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_empat }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_lima }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_rerata }}</td>
            <td class="text-center align-middle">{{ $penilaian->nilai_rerata_x_bobot }}</td>
        </tr>
        @endforeach
        @foreach($jadwal->nilaiUjianSkripsi as $nilaiUjian)
        <tr class="nilai">
            <th colspan="8" class="text-right">Jumlah Nilai</th>
            <td class="text-center align-middle">{{ $nilaiUjian->jumlah_nilai }}</td>
        </tr>
        <tr class="nilai">
            <th colspan="8" class="text-right">Nilai Akhir Ujian Seminar Hasil Skripsi : (Jumlah Nilai / 500) * 100</th>
            <td class="text-center align-middle">{{ $nilaiUjian->nilai_akhir }}</td>
        </tr>
        <tr class="nilai">
            <th colspan="9" class="text-right">Nilai Batas Kelayakan >= 60</th>
        </tr>
        @endforeach
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
                <td class="text-center">{{ $akumulasiSkripsi->seminar_proposal }}</td>
                <td class="text-center">{{ $akumulasiSkripsi->seminar_proposal * 25 / 100 }}</td>
            </tr>
            <tr>
                <td class="text-center">Seminar Hasil </td>
                <td class="text-center">25</td>
                <td class="text-center">{{ $akumulasiSkripsi->seminar_hasil }}</td>
                <td class="text-center">{{ $akumulasiSkripsi->seminar_hasil * 25 / 100}}</td>
            </tr>
            <tr>
                <td class="text-center">Sidang Skripsi </td>
                <td class="text-center">50</td>
                <td class="text-center">{{ $akumulasiSkripsi->sidang_skripsi }}</td>
                <td class="text-center">{{ $akumulasiSkripsi->sidang_skripsi * 50 / 100 }}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Total (Nilai Angka)</th>
                <th class="text-center">{{ $akumulasiSkripsi->total }}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Nilai Huruf</th>
                <th class="text-center">{{ $akumulasiSkripsi->nilai_huruf }}</th>
            </tr>
        </table>

        <p class="text-center">Berdasarkan hasil akumulasi perolehan nilai, maka mahasiswa tersebut dinyatakan :</p>
        <br>
        <h3 class="text-center"><strong>
            @switch($akumulasiSkripsi->nilai_huruf)
                @case('A')
                @case('A-')
                @case('B+')
                @case('B')
                @case('B-')
                @case('C+')
                @case('C')
                    LULUS
                    @break
                @default
                    TIDAK LULUS
            @endswitch
        </strong></h3>
        <br><br>
        <div class="float-left mr-4 ml-0 pl-0">
        <p>Penguji 1</p>
        @if(!empty($dosen->dospengSatuSidang->tanda_tangan))
        <img src="{{ asset('assets/ttd/' . $dosen->dospengSatuSidang->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-2">
        @endif
        <br> <br>
        <p style="font-size:10px;">{{ implode(' ', array_slice(explode(' ', $dosen->dospengSatuSidang->nama), 0, 2)) }}</p>
    </div>

    <div class="float-left mx-5">
        <p>Penguji 2</p>
        @if(!empty($dosen->dospengDuaSidang->tanda_tangan))
        <img src="{{ asset('assets/ttd/' . $dosen->dospengDuaSidang->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-2">
        @endif
        <br> <br>
        <p style="font-size:10px;">{{ implode(' ', array_slice(explode(' ', $dosen->dospengDuaSidang->nama), 0, 2)) }}</p>
    </div>

    <div class="float-left mx-5">
        <p>Penguji 3</p>
        @if(!empty($dosen->dospengTigaSidang->tanda_tangan))
        <img src="{{ asset('assets/ttd/' . $dosen->dospengTigaSidang->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-2">
        @endif
        <br> <br>
        <p style="font-size:10px;">{{ implode(' ', array_slice(explode(' ', $dosen->dospengTigaSidang->nama), 0, 2)) }} </p>
    </div>

    <div class="float-left mx-5" >
        <p>Penguji 4</p>
        @if(!empty($dosen->dospengEmpatSidang->tanda_tangan))
        <img src="{{ asset('assets/ttd/' . $dosen->dospengEmpatSidang->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-2">
        @endif
        <br> <br>
        <p style="font-size:10px;">{{ implode(' ', array_slice(explode(' ', $dosen->dospengEmpatSidang->nama), 0, 2)) }}</p>
    </div>

    <div class="float-left ml-4 mr-0 pr-0" >
        <p>Penguji 5</p>
        @if(!empty($dosen->dospengLimaSidang->tanda_tangan))
        <img src="{{ asset('assets/ttd/' . $dosen->dospengLimaSidang->tanda_tangan) }}" style="width:25%; padding-left:-30px;" class="img pt-2">
        @endif
        <br> <br>
        <p style="font-size:10px;">{{ implode(' ', array_slice(explode(' ', $dosen->dospengLimaSidang->nama), 0, 2)) }}</p>
    </div>

</body>
</html>
