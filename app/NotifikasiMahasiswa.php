<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifikasiMahasiswa extends Model
{
    protected $table = 'notifikasi_mahasiswa';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

}
