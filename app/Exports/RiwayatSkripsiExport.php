<?php

namespace App\Exports;

use App\PendaftarUsulanTopik;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RiwayatSkripsiExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $judul, string $tahapan_skripsi)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->judul = $judul;
        $this->tahapan_skripsi = $tahapan_skripsi;
    }

    public function query()
    {
        $nim = $this->nim;
        $nama = $this->nama;
        $angkatan = $this->angkatan;
        $tahapan_skripsi = $this->tahapan_skripsi;

        $query = PendaftarUsulanTopik::query()->with('mahasiswa')->where('tahapan', 'diterima');
        $query->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->tahapan_skripsi)) ? $query->where('tahapan_skripsi', $this->tahapan_skripsi) : '';
        });
        (!empty($this->judul)) ? $query->where('usulan_judul', 'like', '%' . $this->judul . '%') : '';
        return $query;
    }

    public function map($riwayat): array
    {
        return [
            !empty($riwayat->mahasiswa->nim) ? $riwayat->mahasiswa->nim : '-',
            !empty($riwayat->mahasiswa->nama) ? $riwayat->mahasiswa->nama : '-',
            !empty($riwayat->mahasiswa->angkatan) ? $riwayat->mahasiswa->angkatan : '-',
            !empty($riwayat->mahasiswa->tahapan_skripsi) ? $riwayat->mahasiswa->tahapan_skripsi : '-',
            $riwayat->usulan_judul
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Tahapan Skripsi',
            'Judul Skripsi'
        ];
    }

}