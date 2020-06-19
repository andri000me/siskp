<?php

namespace App\Imports;

use App\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class DosenImport implements ToModel
{
    public function model(array $row)
    {
        $prodi = \App\Prodi::where('nama', 'like', '%'.trim($row[5]).'%')->first();
        $default_pass = Hash::make($row[0]);
        return Dosen::updateOrCreate(['nip' => $row[0]], [
            'nama' => $row[1], 
            'status' => $row[2], 
            'bisa_menguji' => $row[3], 
            'bisa_membimbing' => $row[4], 
            'password' => $default_pass,
            'id_prodi' => $prodi->id
        ]);
    }

}
