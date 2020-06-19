<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = 'bimbingan';

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['waktu'];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
}
