<?php

namespace App\Exports;

use App\DosenPembimbingKp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosbingKpExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $lokasi, string $dosbing_satu_kp, string $dosbing_dua_kp, string $id_semester)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->lokasi = $lokasi;
        $this->dosbing_satu_kp = $dosbing_satu_kp;
        $this->dosbing_dua_kp = $dosbing_dua_kp;
        $this->id_semester = $id_semester;
    }

    public function query()
    {
        $nama = $this->nama;
        $nim = $this->nim;
        $angkatan = $this->angkatan;
        $lokasi = $this->lokasi;
        $dosbing_satu_kp = $this->dosbing_satu_kp;
        $dosbing_dua_kp = $this->dosbing_dua_kp;
        $id_semester = $this->id_semester;
        
        $query = DosenPembimbingKp::query();
        $query->with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
        });
        (!empty($this->lokasi)) ? $query->where('lokasi', 'like', '%' . $this->lokasi . '%') : '';
        (!empty($this->dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $this->dosbing_satu_kp) : '';
        (!empty($this->dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $this->dosbing_dua_kp) : '';
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi->nama) ? $data->mahasiswa->prodi->nama : '-',
            $data->lokasi,
            !empty($data->semester->nama) ? $data->semester->nama : '-',
            !empty($data->dosbingSatuKp->nama) ? $data->dosbingSatuKp->nama : '-',
            !empty($data->dosbingDuaKp->nama) ? $data->dosbingDuaKp->nama : '-'
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Program Studi',
            'Lokasi',
            'Semester',
            'Pembimbing Utama',
            'Pembimbing Pendamping'
        ];
    }

}