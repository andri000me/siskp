<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferensiUtama extends Model
{
    protected $table = 'referensi_utama';

    protected $guarded = [];

    // Relasi N-1 dengan pendaftar_usulan_topik
    public function pendaftarUsulanTopik(){
        return $this->belongsTo('App\PendaftarUsulanTopik', 'id_pendaftar_usulan_topik');
    }
}
