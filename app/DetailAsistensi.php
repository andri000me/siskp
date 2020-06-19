<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailAsistensi extends Model
{
    protected $table = 'detail_asistensi';

    protected $guarded = [];

    // Relasi N-1 dengan asistensi
    public function asistensi(){
        return $this->belongsTo('App\Asistensi', 'id_asistensi');
    }

}
