<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    protected $table = 'jadwal_ujian';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // relasi 1-N dengan peserta_ujian
    public function pesertaUjian(){
        return $this->hasMany('App\PesertaUjian', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan dosen_penguji
    public function dosenPenguji(){
        return $this->hasMany('App\DosenPenguji', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan penilaian_proposal
    public function penilaianProposal(){
        return $this->hasMany('App\PenilaianProposal', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan penilaian_hasil
    public function penilaianHasil(){
        return $this->hasMany('App\PenilaianHasil', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function penilaianSidangSkripsi(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function nilaiUjianSkripsi(){
        return $this->hasMany('App\NilaiUjianSkripsi', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan penilaian_kp
    public function penilaianKp(){
        return $this->hasMany('App\PenilaianKp', 'id_jadwal_ujian');
    }

    // relasi 1-N dengan nilai_ujian_kp
    public function nilaiUjianKp(){
        return $this->hasMany('App\NilaiUjianKp', 'id_jadwal_ujian');
    }

    protected $dates = ['created_at', 'updated_at', 'waktu_mulai', 'waktu_selesai'];

}
