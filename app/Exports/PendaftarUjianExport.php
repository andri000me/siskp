<?php

namespace App\Exports;

use App\PendaftarUjian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PendaftarUjianExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nim, string $angkatan, string $ujian, string $id_prodi, string $id_periode_daftar_ujian)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->ujian = $ujian;
        $this->id_prodi = $id_prodi;
        $this->id_periode_daftar_ujian = $id_periode_daftar_ujian;
    }

    public function query()
    {
        $nama = $this->nama;
        $nim = $this->nim;
        $angkatan = $this->angkatan;
        $ujian = $this->ujian;
        $id_prodi = $this->id_prodi;
        $id_periode_daftar_ujian = $this->id_periode_daftar_ujian;
        
        $query = PendaftarUjian::query();
        $query->with('mahasiswa')->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        (!empty($this->ujian)) ? $query->where('ujian', $this->ujian) : '';
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->pendaftarUsulanTopik->pluck('usulan_judul')->last()) ? $data->mahasiswa->pendaftarUsulanTopik->pluck('usulan_judul')->last() : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi->nama) ? $data->mahasiswa->prodi->nama : '-',
            $data->ujian,
            $data->tahapan,
            !empty($data->periodeDaftarUjian->nama) ? $data->periodeDaftarUjian->nama : '-',
            'Hari ' . $data->created_at->formatLocalized("%A, %d %B %Y") . ' Pukul ' . $data->created_at->formatLocalized("%H:%M:%S") . ' WITA'
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Judul Skripsi',
            'Angkatan',
            'Program Studi',
            'Ujian',
            'Tahapan',
            'Periode',
            'Waktu Upload'
        ];
    }

}