<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesertaUjianLama extends Model
{
    protected $table = 'peserta_ujian_lama';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    protected $dates = ['tanggal'];

}
