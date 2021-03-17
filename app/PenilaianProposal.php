<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianProposal extends Model
{
    protected $table = 'penilaian_proposal';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan dosen
    public function dospengSatuProposal(){
        return $this->belongsTo('App\Dosen', 'dospeng_satu_proposal');
    }

    // Relasi N-1 dengan dosen
    public function dospengDuaProposal(){
        return $this->belongsTo('App\Dosen', 'dospeng_dua_proposal');
    }

    // Relasi N-1 dengan dosen
    public function dospengTigaProposal(){
        return $this->belongsTo('App\Dosen', 'dospeng_tiga_proposal');
    }

    // Relasi N-1 dengan dosen
    public function dospengEmpatProposal(){
        return $this->belongsTo('App\Dosen', 'dospeng_empat_proposal');
    }

    // Relasi N-1 dengan dosen
    public function dospengLimaProposal(){
        return $this->belongsTo('App\Dosen', 'dospeng_lima_proposal');
    }

    // Relasi N-1 dengan indikator_penilaian
    public function indikatorPenilaian(){
        return $this->belongsTo('App\IndikatorPenilaian', 'id_indikator_penilaian');
    }

}
