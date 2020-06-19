<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPlagiasi extends Model
{
    protected $table = 'hasil_plagiasi';

    protected $guarded = [];

    // Relasi N-1 dengan pendaftar_ujian
    public function pendaftarUjian(){
        return $this->belongsTo('App\PendaftarUjian', 'id_pendaftar_ujian');
    }
}
