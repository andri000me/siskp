<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersetujuanUjian extends Model
{
    protected $table = 'persetujuan_ujian';

    protected $guarded = [];

    // Relasi N-1 dengan dosen
    public function dosbingSatuAproval(){
        return $this->belongsTo('App\Dosen', 'dosbing_satu_aproval');
    }

    // Relasi N-1 dengan dosen
    public function dosbingDuaAproval(){
        return $this->belongsTo('App\Dosen', 'dosbing_dua_aproval');
    }

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

}
