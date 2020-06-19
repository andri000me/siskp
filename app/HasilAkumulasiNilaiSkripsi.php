<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilAkumulasiNilaiSkripsi extends Model
{
    protected $table = 'hasil_akumulasi_nilai_skripsi';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }
}
