<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';

    protected $guarded = [];

    // relasi 1-N dengan mahasiswa
    public function mahasiswa(){
        return $this->hasMany('App\Mahasiswa', 'id_prodi');
    }

    // relasi 1-N dengan kaprodi
    public function kaprodi(){
        return $this->hasMany('App\Kaprodi', 'id_prodi');
    }

    // relasi 1-N dengan prodi_kp
    public function prodiKp(){
        return $this->hasMany('App\ProdiKp', 'id_prodi');
    }

    // relasi 1-N dengan dosen
    public function dosen(){
        return $this->hasMany('App\Dosen', 'id_prodi');
    }

}
