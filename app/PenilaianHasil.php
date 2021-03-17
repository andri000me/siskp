<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianHasil extends Model
{
    protected $table = 'penilaian_hasil';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan dosen
    public function dospengSatuHasil(){
        return $this->belongsTo('App\Dosen', 'dospeng_satu_hasil');
    }

    // Relasi N-1 dengan dosen
    public function dospengDuaHasil(){
        return $this->belongsTo('App\Dosen', 'dospeng_dua_hasil');
    }

    // Relasi N-1 dengan dosen
    public function dospengTigaHasil(){
        return $this->belongsTo('App\Dosen', 'dospeng_tiga_hasil');
    }

    // Relasi N-1 dengan dosen
    public function dospengEmpatHasil(){
        return $this->belongsTo('App\Dosen', 'dospeng_empat_hasil');
    }

    // Relasi N-1 dengan dosen
    public function dospengLimaHasil(){
        return $this->belongsTo('App\Dosen', 'dospeng_lima_hasil');
    }

    // Relasi N-1 dengan indikator_penilaian
    public function indikatorPenilaian(){
        return $this->belongsTo('App\IndikatorPenilaian', 'id_indikator_penilaian');
    }

}
