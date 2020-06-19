<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistensi extends Model
{
    protected $table = 'asistensi';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

    // relasi 1-N dengan detail_asistensi
    public function detailAsistensi(){
        return $this->hasMany('App\DetailAsistensi', 'id_asistensi');
    }

}
