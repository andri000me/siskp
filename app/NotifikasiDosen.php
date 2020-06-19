<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifikasiDosen extends Model
{
    protected $table = 'notifikasi_dosen';

    protected $guarded = [];

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

}
