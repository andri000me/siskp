<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodeDaftarTurunKp extends Model
{
    protected $table = 'periode_daftar_turun_kp';

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    // Relasi N-1 dengan semester
    public function semester(){
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    // relasi 1-N dengan pendaftar_usulan_topik
    public function pendaftarTurunKp(){
        return $this->hasMany('App\PendaftarTurunKp', 'id_periode_daftar_turun_kp');
    }
}
