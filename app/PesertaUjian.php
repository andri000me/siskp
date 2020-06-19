<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesertaUjian extends Model
{
    protected $table = 'peserta_ujian';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal_ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }
}
