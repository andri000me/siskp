<?php

namespace App\Exports;

use App\HasilAkumulasiNilaiSkripsi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NilaiUjianExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $id_prodi)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->id_prodi = $id_prodi;
    }

    public function query()
    {
        $nim = $this->nim;
        $nama = $this->nama;
        $angkatan = $this->angkatan;
        $id_prodi = $this->id_prodi;

        $query = HasilAkumulasiNilaiSkripsi::query();
        $query->with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        return $query;
    }

    public function map($nilai): array
    {
        return [
            !empty($nilai->mahasiswa->nim) ? $nilai->mahasiswa->nim : '-',
            !empty($nilai->mahasiswa->nama) ? $nilai->mahasiswa->nama : '-',
            !empty($nilai->mahasiswa->angkatan) ? $nilai->mahasiswa->angkatan : '-',
            !empty($nilai->mahasiswa->prodi->nama) ? $nilai->mahasiswa->prodi->nama : '-',
            $nilai->seminar_proposal,
            $nilai->seminar_hasil,
            $nilai->sidang_skripsi,
            $nilai->total,
            $nilai->nilai_huruf,
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Program Studi',
            'Seminar Proposal',
            'Seminar Hasil',
            'Sidang Skripsi',
            'Total',
            'Huruf'
        ];
    }

}