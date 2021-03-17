<?php

namespace App\Exports;

use App\JadwalUjian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JadwalUjianExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $bulan, string $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function query()
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        $query = JadwalUjian::query();
        $query->whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC');
        return $query;
    }

    public function map($data): array
    {
        return [
            $data->mahasiswa->nama . "\n" . $data->mahasiswa->nim,
            $data->mahasiswa->prodi->nama . "\n" . $data->mahasiswa->angkatan,
            ucwords($data->ujian),
            ($data->ujian !== 'kerja-praktek') ? $data->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : $data->mahasiswa->pendaftarUjian->last()->judul_laporan_kp,
            ($data->ujian !== 'kerja-praktek') ?
            '1). ' . $data->dosenPenguji[0]->dosen->nama . "\n" .
            '2). ' . $data->dosenPenguji[1]->dosen->nama . "\n" .
            '3). ' . $data->dosenPenguji[2]->dosen->nama . "\n" .
            '4). ' . $data->dosenPenguji[3]->dosen->nama . "\n" .
            '5). ' .  $data->dosenPenguji[4]->dosen->nama
            : '1). ' . $data->dosenPenguji[0]->dosen->nama . "\n" .
            '2). ' . $data->dosenPenguji[1]->dosen->nama . "\n" .
            '3). ' . $data->dosenPenguji[2]->dosen->nama
        ];
    }

    public function headings(): array
    {
        return [
            'Nama & NIM',
            'Program Studi & Angkatan',
            'Ujian',
            'Judul Laporan',
            'Dosen Penguji'
        ];
    }

}
