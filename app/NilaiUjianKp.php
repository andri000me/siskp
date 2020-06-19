<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiUjianKp extends Model
{
    protected $table = 'nilai_ujian_kp';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }
    
}
