<?php

namespace App\Exports;

use App\DosenPembimbingSkripsi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosbingSkripsiExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $dosbing_satu_skripsi, string $dosbing_dua_skripsi, string $id_semester)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->dosbing_satu_skripsi = $dosbing_satu_skripsi;
        $this->dosbing_dua_skripsi = $dosbing_dua_skripsi;
        $this->id_semester = $id_semester;
    }

    public function query()
    {
        $nama = $this->nama;
        $nim = $this->nim;
        $angkatan = $this->angkatan;
        $dosbing_satu_skripsi = $this->dosbing_satu_skripsi;
        $dosbing_dua_skripsi = $this->dosbing_dua_skripsi;
        $id_semester = $this->id_semester;
        
        $query = DosenPembimbingSkripsi::query();
        $query->with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
        });
        (!empty($this->dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $this->dosbing_satu_skripsi) : '';
        (!empty($this->dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $this->dosbing_dua_skripsi) : '';
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi->nama) ? $data->mahasiswa->prodi->nama : '-',
            !empty($data->mahasiswa->pendaftarUsulanTopik->pluck('usulan_judul')->last()) ? $data->mahasiswa->pendaftarUsulanTopik->pluck('usulan_judul')->last() : '-',
            !empty($data->semester->nama) ? $data->semester->nama : '-',
            !empty($data->dosbingSatuSkripsi->nama) ? $data->dosbingSatuSkripsi->nama : '-',
            !empty($data->dosbingDuaSkripsi->nama) ? $data->dosbingDuaSkripsi->nama : '-'
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Program Studi',
            'Judul Skripsi',
            'Semester',
            'Pembimbing Utama',
            'Pembimbing Pendamping'
        ];
    }

}