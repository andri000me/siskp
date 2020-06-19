<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosbingBerhalangan extends Model
{
    protected $table = 'dosbing_berhalangan';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan semester
    public function semester(){
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

}
