<?php

namespace App\Exports;

use App\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AkademikExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $id_prodi, string $id_dosen, string $tahapan_kp, string $tahapan_skripsi, string $kontrak_kp, string $kontrak_skripsi)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->id_prodi = $id_prodi;
        $this->id_dosen = $id_dosen;
        $this->tahapan_kp = $tahapan_kp;
        $this->tahapan_skripsi = $tahapan_skripsi;
        $this->kontrak_kp = $kontrak_kp;
        $this->kontrak_skripsi = $kontrak_skripsi;
    }

    public function query()
    {
        $query = Mahasiswa::query();
        (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
        (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
        (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
        (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        (!empty($this->id_dosen)) ? $query->where('id_dosen', $this->id_dosen) : '';
        (!empty($this->tahapan_kp)) ? $query->where('tahapan_kp', $this->tahapan_kp) : '';
        (!empty($this->tahapan_skripsi)) ? $query->where('tahapan_skripsi', $this->tahapan_skripsi) : '';
        (!empty($this->kontrak_kp)) ? $query->where('kontrak_kp', $this->kontrak_kp) : '';  
        (!empty($this->kontrak_skripsi)) ? $query->where('kontrak_skripsi', $this->kontrak_skripsi) : '';  
        return $query;
    }

    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->angkatan,
            !empty($mahasiswa->prodi->nama) ? $mahasiswa->prodi->nama : '-',
            $mahasiswa->tahapan_kp,
            $mahasiswa->tahapan_skripsi,
            $mahasiswa->kontrak_kp,
            $mahasiswa->kontrak_skripsi
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Angkatan',
            'Program Studi',
            'Tahapan Kerja Praktek',
            'Tahapan Skripsi',
            'Kontrak Kerja Praktek',
            'Kontrak Skripsi'
        ];
    }

}