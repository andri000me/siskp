<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdiKp extends Model
{
    protected $table = 'prodi_kp';

    protected $guarded = [];

    // Relasi N-1 dengan prodi
    public function prodi(){
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }
}
