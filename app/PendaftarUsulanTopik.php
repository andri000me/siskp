<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendaftarUsulanTopik extends Model
{
    protected $table = 'pendaftar_usulan_topik';

    protected $guarded = [];

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan periode_daftar_usulan_topik
    public function periodeDaftarUsulanTopik(){
        return $this->belongsTo('App\PeriodeDaftarUsulanTopik', 'id_periode_daftar_usulan_topik');
    }

    // relasi 1-N dengan referensi_utama
    public function referensiUtama(){
        return $this->hasMany('App\ReferensiUtama', 'id_pendaftar_usulan_topik');
    }
}
