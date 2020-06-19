<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendaftarUjian extends Model
{
    protected $table = 'pendaftar_ujian';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan periode_daftar_ujian
    public function periodeDaftarUjian(){
        return $this->belongsTo('App\PeriodeDaftarUjian', 'id_periode_daftar_ujian');
    }

    // relasi 1-N dengan hasil_plagiasi
    public function hasilPlagiasi(){
        return $this->hasMany('App\HasilPlagiasi', 'id_pendaftar_ujian');
    }
}
