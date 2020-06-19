<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kaprodi extends Model
{
    protected $table = 'kaprodi';

    protected $guarded = [];

    // Relasi N-1 dengan prodi
    public function prodi(){
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }
    
}
