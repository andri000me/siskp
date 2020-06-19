<?php

namespace App\Imports;

use App\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class TesImport implements ToModel
{
    public function model(array $row)
    {
        // import semua mahasiswa
        // $prodi = \App\Prodi::find($row[3]);
        // $dosen = \App\Dosen::find($row[4]);
        // $default_pass = Hash::make(date('YmdHis'));
        // $mahasiswa = Mahasiswa::updateOrCreate(['nim' => $row[1]], [
        //     'nama' => $row[2], 
        //     'password' => $default_pass, 
        //     'id_prodi' => $prodi->id, 
        //     'angkatan' => $row[0], 
        //     'id_dosen' => $dosen->id 
        // ]);
        // return $mahasiswa;

        // import alumni PTI
        // $prodi = \App\Prodi::find($row[3]);
        // $default_pass = Hash::make(date('YmdHis'));
        // $mahasiswa = Mahasiswa::updateOrCreate(['nim' => $row[0]], [
        //     'nama' => $row[1], 
        //     'password' => $default_pass, 
        //     'angkatan' => $row[4], 
        //     'id_prodi' => $prodi->id, 
        //     'tahapan_skripsi' => 'lulus'
        // ]);
        // return $mahasiswa;

        // import alumni SI
        // $prodi = \App\Prodi::find($row[3]);
        // $default_pass = Hash::make(date('YmdHis'));
        // $mahasiswa = Mahasiswa::updateOrCreate(['nim' => $row[0]], [
        //     'nama' => $row[1], 
        //     'password' => $default_pass, 
        //     'angkatan' => $row[4], 
        //     'id_prodi' => $prodi->id,
        //     'tahapan_skripsi' => 'lulus',
        //     'tahapan_kp' => 'lulus' 
        // ]);
        // return $mahasiswa;

        // import judul skripsi
        // $mahasiswa = \App\Mahasiswa::where('nim', $row[0])->first();
        // $judul = \App\PendaftarUsulanTopik::updateOrCreate(['id_mahasiswa' => $mahasiswa->id], [
        //     'usulan_judul' => $row[2], 
        //     'tahapan' => 'diterima' 
        // ]);
        // return $judul;

        // import dosen pembimbing skripsi yang mahasiswa sudah lulus
        // $mahasiswa = \App\Mahasiswa::where('nim', $row[0])->first();
        // $dosbing = \App\DosenPembimbingSkripsi::updateOrCreate(['id_mahasiswa' => $mahasiswa->id], [
        //     'dosbing_satu_skripsi' => $row[1], 
        //     'dosbing_dua_skripsi' => $row[2] 
        // ]);
        // return $dosbing;

        // import jurnal skripsi yang mahasiswa sudah lulus
        // $mahasiswa = \App\Mahasiswa::where('nim', $row[0])->first();
        // $jurnal = \App\RiwayatSkripsi::updateOrCreate(['id_mahasiswa' => $mahasiswa->id], [
        //     'file_jurnal_skripsi' => $row[5] 
        // ]);
        // return $jurnal;

        // import judul skripsi usulan topik periode april 2020
        // $mahasiswa = \App\Mahasiswa::where('nim', $row[0])->first();
        // $judul = \App\PendaftarUsulanTopik::updateOrCreate(['id_mahasiswa' => $mahasiswa->id], [
        //     'usulan_judul' => $row[1], 
        //     'tahapan' => 'diterima', 
        //     'id_periode_daftar_usulan_topik' => $row[2]  
        // ]);
        // return $judul;

    }
}
