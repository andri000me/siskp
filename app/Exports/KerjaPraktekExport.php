<?php

namespace App\Exports;

use App\DosenPembimbingKp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KerjaPraktekExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $id_dosen, string $nama, string $nim, string $angkatan, string $tahapan_kp, string $id_prodi, string $kontrak_kp, string $pembimbing, string $id_semester)
    {
        $this->id_dosen = $id_dosen;
        $this->nama = $nama;
        $this->nim = $nim;
        $this->angkatan = $angkatan;
        $this->tahapan_kp = $tahapan_kp;
        $this->id_prodi = $id_prodi;
        $this->kontrak_kp = $kontrak_kp;
        $this->pembimbing = $pembimbing;
        $this->id_semester = $id_semester;
    }

    public function query()
    {
        $id_dosen = $this->id_dosen;
        $nim = $this->nim;
        $nama = $this->nama;
        $angkatan = $this->angkatan;
        $tahapan_kp = $this->tahapan_kp;
        $id_prodi = $this->id_prodi;
        $kontrak_kp = $this->kontrak_kp;
        $pembimbing = $this->pembimbing;
        $id_semester = $this->id_semester;

        $query = DosenPembimbingKp::query();
        $query->with('mahasiswa', 'semester')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $kontrak_kp, $id_prodi){
            (!empty($this->nim)) ? $query->where('nim', 'like', '%' . $this->nim . '%') : '';
            (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
            (!empty($this->angkatan)) ? $query->where('angkatan', $this->angkatan) : '';
            (!empty($this->tahapan_kp)) ? $query->where('tahapan_kp', $this->tahapan_kp) : '';
            (!empty($this->kontrak_kp)) ? $query->where('kontrak_kp', $this->kontrak_kp) : '';
            (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        });
        (!empty($this->id_semester)) ? $query->where('id_semester', $this->id_semester) : '';
        if(!empty($this->pembimbing)){
            if($this->pembimbing === 'utama') $query->where('dosbing_satu_kp', $this->id_dosen);
            else $query->where('dosbing_dua_kp', $this->id_dosen);
        }
        return $query;
    }

    public function map($data): array
    {
        return [
            !empty($data->mahasiswa->nim) ? $data->mahasiswa->nim : '-',
            !empty($data->mahasiswa->nama) ? $data->mahasiswa->nama : '-',
            !empty($data->mahasiswa->angkatan) ? $data->mahasiswa->angkatan : '-',
            !empty($data->mahasiswa->prodi) ? $data->mahasiswa->prodi : '-',
            !empty($data->mahasiswa->tahapan_kp) ? $data->mahasiswa->tahapan_kp : '-',
            !empty($data->mahasiswa->kontrak_kp) ? $data->mahasiswa->kontrak_kp : '-',
            ($data->dosbingSatuKp->id === $this->id_dosen) ? 'UTAMA' : 'PENDAMPING',
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
            'Tahapan KP',
            'Kontrak KP',
            'Pembimbing',
            'Semester'
        ];
    }

}