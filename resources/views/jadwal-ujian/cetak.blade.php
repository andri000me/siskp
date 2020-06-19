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

        <!-- Header -->
        <br>
        <h5 class="text-center"> DAFTAR JADWAL UJIAN {{ strtoupper($bulan) }} {{ $tahun }}</h5>
        <br>
        <table class="table table-striped">
            <tr>
                <th>NAMA & NIM</th>
                <th>TEMPAT & WAKTU</th>
                <th>UJIAN</th>
                <th>DOSEN PENGUJI</th>
            </tr>
            @foreach($daftar_jadwal as $jadwal)
                <tr>
                    <td>{{ $jadwal->mahasiswa->nama }} <br> {{ $jadwal->mahasiswa->nim }}</td>
                    <td>{{ $jadwal->tempat }}, {{ $jadwal->waktu_mulai->formatLocalized("%A, %d %B %Y") }} <br> Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA</td>
                    <td>{{ strtoupper($jadwal->ujian) }}</td>
                    <td>
                        @foreach($jadwal->dosenPenguji as $penguji)
                            {{ $penguji->dospeng }}. {{ $penguji->dosen->nama }} <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
</body>
</html>