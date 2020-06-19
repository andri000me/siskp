<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianKp extends Model
{
    protected $table = 'penilaian_kp';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

    // Relasi N-1 dengan indikator_penilaian
    public function indikatorPenilaian(){
        return $this->belongsTo('App\IndikatorPenilaian', 'id_indikator_penilaian');
    }
    
}
