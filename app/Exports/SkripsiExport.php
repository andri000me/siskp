<?php

namespace App\Exports;

use App\DosenPembimbingSkripsi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SkripsiExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $id_dosen, string $nama, string $nim, string $angkatan, string $tahapan_skripsi, string $id_prodi, string $kontrak_skripsi, string $pembimbing, string $id_semester)
    {
        $this->id_dosen = $id_dosen;
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->tahapan_skripsi = $tahapan_skripsi;
        $this->id_prodi = $id_prodi;
        $this->kontrak_skripsi = $kontrak_skripsi;
        $this->pembimbing = $pembimbing;
        $this->id_semester = $id_semester;
    }

    public function query()
    {
        $id_dosen = $this->id_dosen;
        $nim = $this->nim;
        $nama = $this->nama;
        $angkatan = $this->angkatan;
        $tahapan_skripsi = $this->tahapan_skripsi;
        $id_prodi = $this->id_prodi;
        $kontrak_skripsi = $this->kontrak_skripsi;
        $pembimbing = $this->pembimbing;
        $id_semester = $this->id_semester;

        $query = DosenPembimbingSkripsi::query();
        $query->with('mahasiswa', 'semester')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $kontrak_skripsi, $id_prodi){
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->tahapan_skripsi)) ? $query->where('tahapan_skripsi', $this->tahapan_skripsi) : '';
            (!empty($this->kontrak_skripsi)) ? $query->where('kontrak_skripsi', $this->kontrak_skripsi) : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        (!empty($this->id_semester)) ? $query->where('id_semester', $this->id_semester) : '';
        if(!empty($this->pembimbing)){
            if($this->pembimbing === 'utama') $query->where('dosbing_satu_skripsi', $this->id_dosen);
            else $query->where('dosbing_dua_skripsi', $this->id_dosen);
        }
        return $query;
    }

    public function map($data): array
    {
        return [
            $data->mahasiswa->nim,
            $data->mahasiswa->nama,
            $data->mahasiswa->angkatan,
            $data->mahasiswa->prodi->nama,
            $data->mahasiswa->pendaftarUsulanTopik->pluck('usulan_judul')->last(),
            $data->mahasiswa->tahapan_skripsi,
            $data->mahasiswa->kontrak_skripsi,
            ($data->dosbingSatuSkripsi->id === $this->id_dosen) ? 'UTAMA' : 'PENDAMPING',
            !empty($data->semester->nama) ? $data->semester->nama : '-'
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
            'Tahapan Skripsi',
            'Kontrak Skripsi',
            'Pembimbing',
            'Semester'
        ];
    }

}