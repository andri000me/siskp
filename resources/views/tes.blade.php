<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tes</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>
<body>
    <h4 class="text-center">TABEL PENILAIAN PROPOSAL MASING-MASING DOSEN</h4>
    <table class="table table-bordered">
        <tr>
            <th class="text-center align-middle">Indikator Penilaian</th>
            <th class="text-center align-middle">Bobot (%)</th>
            <th class="text-center align-middle">Skor Penilaian (1-5) </th>
        </tr>
        
        <tr>
            <td>Penyajian Materi Presentasi</td>
            <td class="text-center">20%</td>
            <td class="text-center">
                <select name="" class="form-control">
                    <option value="">-- Skor Penilaian --</option>
                    <option value="">Sangat Buruk (1)</option>
                    <option value="">Buruk (2)</option>
                    <option value="">Cukup (3)</option>
                    <option value="">Baik (4)</option>
                    <option value="">Sangat Baik (5)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Penguasaan Materi</td>
            <td class="text-center">20%</td>
            <td class="text-center">
                <select name="" class="form-control">
                    <option value="">-- Skor Penilaian --</option>
                    <option value="">Sangat Buruk (1)</option>
                    <option value="">Buruk (2)</option>
                    <option value="">Cukup (3)</option>
                    <option value="">Baik (4)</option>
                    <option value="">Sangat Baik (5)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Isi Proposal</td>
            <td class="text-center">30%</td>
            <td class="text-center">
                <select name="" class="form-control">
                    <option value="">-- Skor Penilaian --</option>
                    <option value="">Sangat Buruk (1)</option>
                    <option value="">Buruk (2)</option>
                    <option value="">Cukup (3)</option>
                    <option value="">Baik (4)</option>
                    <option value="">Sangat Baik (5)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rancangan Penelitian</td>
            <td class="text-center">20%</td>
            <td class="text-center">
                <select name="" class="form-control">
                    <option value="">-- Skor Penilaian --</option>
                    <option value="">Sangat Buruk (1)</option>
                    <option value="">Buruk (2)</option>
                    <option value="">Cukup (3)</option>
                    <option value="">Baik (4)</option>
                    <option value="">Sangat Baik (5)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Orisinalitas</td>
            <td class="text-center">10%</td>
            <td class="text-center">
                <select name="" class="form-control">
                    <option value="">-- Skor Penilaian --</option>
                    <option value="">Sangat Buruk (1)</option>
                    <option value="">Buruk (2)</option>
                    <option value="">Cukup (3)</option>
                    <option value="">Baik (4)</option>
                    <option value="">Sangat Baik (5)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="text-right font-weight-bold align-middle" colspan="2">Aksi </td>
            <td> <button type="submit" class="btn btn-primary btn-sm">Submit</button> </td>
        </tr>
    </table>

    <br>
    <h4 class="text-center">TABEL NILAI UJIAN PROPOSAL</h4>
    <table class="table table-bordered">
        <tr>
            <th class="text-center align-middle" rowspan="2">Indikator Penilaian</th>
            <th class="text-center align-middle" rowspan="2">Bobot (%)</th>
            <th class="text-center align-middle" colspan="4">Nilai Skor Penguji</th>
            <th class="text-center align-middle" rowspan="2">Rata-Rata</th>
            <th class="text-center align-middle" rowspan="2">Bobot x Rata-Rata</th>
        </tr>
        <tr>
            <td class="text-center align-middle">1</td>
            <td class="text-center align-middle">2</td>
            <td class="text-center align-middle">3</td>
            <td class="text-center align-middle">4</td>
        </tr>
        <tr>
            <td>Penyajian Materi Presentasi</td>
            <td class="text-center">20%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Penguasaan Materi</td>
            <td class="text-center">20%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Isi Proposal</td>
            <td class="text-center">30%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Rancangan Penelitian</td>
            <td class="text-center">20%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Orisinalitas</td>
            <td class="text-center">10%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="text-right font-weight-bold align-middle" colspan="7">Jumlah Nilai</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="text-right font-weight-bold align-middle" colspan="7">Nilai Akhir Seminar Proposal: (Jumlah Nilai / 500) * 100 </td>
            <td>&nbsp;</td>
        </tr>
    </table>

</body>
</html>