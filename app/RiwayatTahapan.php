<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatTahapan extends Model
{
    protected $table = 'riwayat_tahapan';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }
}
