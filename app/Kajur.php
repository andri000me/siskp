<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kajur extends Model
{
    protected $table = 'kajur';

    protected $guarded = [];

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
}
