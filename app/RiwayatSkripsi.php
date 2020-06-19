<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatSkripsi extends Model
{
    protected $table = 'riwayat_skripsi';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

}
