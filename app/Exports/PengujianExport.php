<?php

namespace App\Exports;

use App\DosenPenguji;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengujianExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $id_dosen, string $waktu, string $ujian)
    {
        $this->id_dosen = $id_dosen;
        $this->waktu = $waktu;
        $this->ujian = $ujian;
    }

    public function query()
    {
        $id_dosen = $this->id_dosen;
        $waktu = $this->waktu;
        $ujian = $this->ujian;
        
        $query = DosenPenguji::query();
        $query->with('jadwalUjian')->where('id_dosen', $id_dosen)->whereHas('jadwalUjian', function ($query) use ($waktu, $ujian){
            (!empty($this->waktu)) ? $query->where('waktu_mulai', 'like', '%' . $this->waktu . '%') : '';
            (!empty($this->ujian)) ? $query->where('ujian', $this->ujian) : '';
        });
        return $query;
    }

    public function map($data): array
    {
        return [
            $data->jadwalUjian->mahasiswa->nim,
            $data->jadwalUjian->mahasiswa->nama,
            $data->jadwalUjian->mahasiswa->angkatan,
            $data->jadwalUjian->mahasiswa->prodi->nama,
            $data->jadwalUjian->ujian,
            'Pukul ' . date('H:i', strtotime($data->jadwalUjian->waktu_mulai)) . '-' . date('H:i', strtotime($data->jadwalUjian->waktu_selesai)) . ' WITA',
            $data->jadwalUjian->tempat,
            $data->dospeng
        ];
    }
    
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Angkatan',
            'Program Studi',
            'Ujian',
            'Waktu',
            'Tempat',
            'Penguji'
        ];
    }

}