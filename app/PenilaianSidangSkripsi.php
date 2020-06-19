<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianSidangSkripsi extends Model
{
    protected $table = 'penilaian_sidang_skripsi';

    protected $guarded = [];

    // Relasi N-1 dengan jadwal ujian
    public function jadwalUjian(){
        return $this->belongsTo('App\JadwalUjian', 'id_jadwal_ujian');
    }

    // Relasi N-1 dengan dosen
    public function dospengSatuSidang(){
        return $this->belongsTo('App\Dosen', 'dospeng_satu_sidang');
    }

    // Relasi N-1 dengan dosen
    public function dospengDuaSidang(){
        return $this->belongsTo('App\Dosen', 'dospeng_dua_sidang');
    }

    // Relasi N-1 dengan dosen
    public function dospengTigaSidang(){
        return $this->belongsTo('App\Dosen', 'dospeng_tiga_sidang');
    }

    // Relasi N-1 dengan dosen
    public function dospengEmpatSidang(){
        return $this->belongsTo('App\Dosen', 'dospeng_empat_sidang');
    }

    // Relasi N-1 dengan indikator_penilaian
    public function indikatorPenilaian(){
        return $this->belongsTo('App\IndikatorPenilaian', 'id_indikator_penilaian');
    }

}
