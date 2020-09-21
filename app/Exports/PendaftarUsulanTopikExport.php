<?php

namespace App\Exports;

use App\PendaftarUsulanTopik;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PendaftarUsulanTopikExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $usulan_judul, string $id_prodi, string $id_periode_daftar_usulan_topik)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->usulan_judul = $usulan_judul;
        $this->id_prodi = $id_prodi;
        $this->id_periode_daftar_usulan_topik = $id_periode_daftar_usulan_topik;
    }

    public function query()
    {
        $nama = $this->nama;
        $nim = $this->nim;
        $angkatan = $this->angkatan;
        $usulan_judul = $this->usulan_judul;
        $id_prodi = $this->id_prodi;
        $id_periode_daftar_usulan_topik = $this->id_periode_daftar_usulan_topik;
        
        $query = PendaftarUsulanTopik::query();
        $query->with('mahasiswa')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        (!empty($this->usulan_judul)) ? $query->where('usulan_judul', 'like', '%' . $this->usulan_judul . '%') : '';
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi->nama) ? $data->mahasiswa->prodi->nama : '-',
            $data->usulan_topik,
            $data->usulan_judul,
            $data->tahapan,
            !empty($data->periodeDaftarUsulanTopik->nama) ? $data->periodeDaftarUsulanTopik->nama : '-',
            $data->mahasiswa->dosen->nama,
            'Hari ' . $data->created_at->formatLocalized("%A, %d %B %Y") . ' Pukul ' . $data->created_at->formatLocalized("%H:%M:%S") . ' WITA'
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Program Studi',
            'Topik Skripsi',
            'Judul Skripsi',
            'Tahapan',
            'Periode',
            'Pendamping Akademik',
            'Waktu Upload'
        ];
    }

}