<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    // relasi 1-N dengan periode_daftar_turun_kp
    public function periodeDaftarTurunKp(){
        return $this->hasMany('App\PeriodeDaftarTurunKp', 'id_semester');
    }

    // relasi 1-N dengan periode_daftar_usulan_topik
    public function periodeDaftarUsulanTopik(){
        return $this->hasMany('App\PeriodeDaftarUsulanTopik', 'id_semester');
    }

    // relasi 1-N dengan periode_daftar_ujian
    public function periodeDaftarUjian(){
        return $this->hasMany('App\PeriodeDaftarUjian', 'id_semester');
    }

    // relasi 1-N dengan dosen_pembimbing_skripsi
    public function dosenPembimbingSkripsi(){
        return $this->hasMany('App\DosenPembimbingSkripsi', 'id_semester');
    }

    // relasi 1-N dengan dosen_pembimbing_kp
    public function dosenPembimbingKp(){
        return $this->hasMany('App\DosenPembimbingKp', 'id_semester');
    }

}
