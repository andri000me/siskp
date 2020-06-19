<?php

namespace App\Imports;

use App\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class MahasiswaImportMaba implements ToModel
{
    public function model(array $row)
    {
        $prodi = \App\Prodi::where('nama', 'like', '%'.trim($row[2]).'%')->first();
        $default_pass = Hash::make(now());

        $mahasiswa = Mahasiswa::updateOrCreate(['nim' => $row[0]], [
            'nama' => $row[1], 
            'password' => $default_pass, 
            'id_prodi' => $prodi->id, 
            'angkatan' => $row[3],
            'id_dosen' => $row[4] 
        ]);
        return $mahasiswa;
    }

}
