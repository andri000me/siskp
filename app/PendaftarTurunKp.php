<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendaftarTurunKp extends Model
{
    protected $table = 'pendaftar_turun_kp';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan periode_daftar_usulan_topik
    public function periodeDaftarTurunKp(){
        return $this->belongsTo('App\PeriodeDaftarTurunKp', 'id_periode_daftar_turun_kp');
    }

}
