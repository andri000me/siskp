<?php

namespace App\Exports;

use App\PendaftarTurunKp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PendaftarTurunKpExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $instansi, string $id_prodi, string $id_periode_daftar_turun_kp)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->instansi = $instansi;
        $this->id_prodi = $id_prodi;
        $this->id_periode_daftar_turun_kp = $id_periode_daftar_turun_kp;
    }

    public function query()
    {
        $nama = $this->nama;
        $nim = $this->nim;
        $angkatan = $this->angkatan;
        $instansi = $this->instansi;
        $id_prodi = $this->id_prodi;
        $id_periode_daftar_turun_kp = $this->id_periode_daftar_turun_kp;
        
        $query = PendaftarTurunKp::query();
        $query->with('mahasiswa')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        (!empty($this->instansi)) ? $query->where('instansi', 'like', '%' . $this->instansi . '%') : '';
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi->nama) ? $data->mahasiswa->prodi->nama : '-',
            $data->instansi,
            $data->alamat,
            $data->tahapan,
            !empty($data->periodeDaftarTurunKp->nama) ? $data->periodeDaftarTurunKp->nama : '-',
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
            'Instansi',
            'Alamat',
            'Tahapan',
            'Periode',
            'Waktu Upload'
        ];
    }

}