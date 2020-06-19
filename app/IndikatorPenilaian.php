<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndikatorPenilaian extends Model
{
    protected $table = 'indikator_penilaian';

    protected $guarded = [];

    // relasi 1-N dengan penilaian_proposal
    public function penilaianProposal(){
        return $this->hasMany('App\PenilaianProposal', 'id_indikator_penilaian');
    }

    // relasi 1-N dengan penilaian_hasil
    public function penilaianHasil(){
        return $this->hasMany('App\PenilaianHasil', 'id_indikator_penilaian');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function penilaianSidangSkripsi(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'id_indikator_penilaian');
    }

    // relasi 1-N dengan penilaian_kp
    public function penilaianKp(){
        return $this->hasMany('App\PenilaianKp', 'id_indikator_penilaian');
    }

    
}
