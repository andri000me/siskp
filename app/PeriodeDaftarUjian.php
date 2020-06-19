<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodeDaftarUjian extends Model
{
    protected $table = 'periode_daftar_ujian';

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    // Relasi N-1 dengan semester
    public function semester(){
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    // relasi 1-N dengan pendaftar_ujian
    public function pendaftarUjian(){
        return $this->hasMany('App\PendaftarUjian', 'id_periode_daftar_ujian');
    }

    
}
