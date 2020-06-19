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
        <p class="font-weight-bold mb-0 pb-0">Nama & NIM Mahasiwa :</p>
        <p class="mb-2 mt-0">{{ $topik->mahasiswa->nama }} / {{ $topik->mahasiswa->nim }}</p>
        
        <p class="font-weight-bold mb-0 pb-0">Program Studi :</p>
        <p class="mb-2 mt-0">{{ $topik->mahasiswa->prodi->nama }}</p>

        <p class="font-weight-bold mb-0 pb-0">Usulan Topik :</p>
        <p class="mb-2 mt-0">{{ $topik->usulan_topik }}</p>

        <p class="font-weight-bold mb-0 pb-0">Usulan Judul :</p>
        <p class="mb-2 mt-0">{{ $topik->usulan_judul }}</p>

        <p class="font-weight-bold mb-0 pb-0">Permasalahan :</p>
        <p class="mb-2 mt-0">{!! $topik->permasalahan !!}</p>

        <p class="font-weight-bold mb-0 pb-0">Tujuan :</p>
        <p class="mb-2 mt-0">{!! $topik->tujuan !!}</p>

        <p class="font-weight-bold mb-0 pb-0">Manfaat :</p>
        <p class="mb-2 mt-0">{!! $topik->manfaat !!}</p>

        <p class="font-weight-bold mb-0 pb-0">Metode Penelitian :</p>
        <p class="mb-2 mt-0">{!! $topik->metode_penelitian !!}</p>

        <p class="font-weight-bold mb-0 pb-0">Metode Pengembangan Sistem :</p>
        <p class="mb-2 mt-0">{!! $topik->metode_pengembangan_sistem !!}</p>

        <p class="font-weight-bold mb-0 pb-0">Tahapan Penelitian :</p>
        <p class="mb-2 mt-0">{!! $topik->metode_penelitian !!}</p>

        <h6 class="my-0">Referensi Utama (Jurnal Ilmiah Yang Relevan)</h6>
        <table class="table table-striped table-bordered">
            <tr>
                <th>No.</th>
                <th>Nama Penulis</th>
                <th>Judul Artikel</th>
                <th>Jurnal Ilmiah (Nama, Volume, Nomor & Tahun Jurnal)</th>
                <th>Keterkaitan dengan Usulan Skripsi</th>
            </tr>
            <?php $i=1 ?>
            @foreach($topik->referensiUtama as $referensi)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $referensi->nama_penulis }}</td>
                <td>{{ $referensi->judul_artikel }}</td>
                <td>{{ $referensi->jurnal_ilmiah }}</td>
                <td>{!! $referensi->keterkaitan !!}</td>
            </tr>
            @endforeach
        </table>

</body>
</html>