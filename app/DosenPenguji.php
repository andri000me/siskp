<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenPenguji extends Model
{
    protected $table = 'dosen_penguji';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal_ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
}
