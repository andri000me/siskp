<?php

namespace App\Exports;

use App\Dosen;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosenExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(string $nama, string $nip, string $id_prodi, string $status, string $bisa_menguji, string $bisa_membimbing)
    {
        $this->nama = $nama;
        $this->nip = $nip;
        $this->id_prodi = $id_prodi;
        $this->status = $status;
        $this->bisa_menguji = $bisa_menguji;
        $this->bisa_membimbing = $bisa_membimbing;
    }

    public function query()
    {
        $query = Dosen::query();
        (!empty($this->nama)) ? $query->where('nama', 'like', '%' . $this->nama . '%') : '';
        (!empty($this->nip)) ? $query->where('nip', 'like', '%' . $this->nip . '%') : '';
        (!empty($this->id_prodi)) ? $query->where('id_prodi', $this->id_prodi) : '';
        (!empty($this->status)) ? $query->where('status', $this->status) : '';
        (!empty($this->bisa_menguji)) ? $query->where('bisa_menguji', $this->bisa_menguji) : '';
        (!empty($this->bisa_membimbing)) ? $query->where('bisa_membimbing', $this->bisa_membimbing) : '';  
        return $query;
    }

    public function map($dosen): array
    {
        return [
            $dosen->id,
            "'" . $dosen->nip,
            $dosen->nama,
            !empty($dosen->prodi->nama) ? $dosen->prodi->nama : '-',
            $dosen->status,
            $dosen->bisa_menguji,
            $dosen->bisa_membimbing
        ];
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'NIP',
            'Nama',
            'Program Studi',
            'Status',
            'Bisa Menguji',
            'Bisa Membimbing'
        ];
    }

}