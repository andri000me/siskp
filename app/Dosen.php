<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $guarded = [];

    // relasi 1-N dengan kajur
    public function kajur(){
        return $this->hasMany('App\Kajur', 'id_dosen');
    }

    // relasi 1-N dengan mahasiswa
    public function mahasiswa(){
        return $this->hasMany('App\Mahasiswa', 'id_dosen');
    }

    // relasi 1-N dengan kaprodi
    public function kaprodi(){
        return $this->hasMany('App\Kaprodi', 'id_dosen');
    }

    // relasi 1-N dengan bimbingan
    public function bimbingan(){
        return $this->hasMany('App\Bimbingan', 'id_dosen');
    }

    // relasi 1-N dengan dosen_pembimbing_skripsi
    public function dosbingSatuSkripsi(){
        return $this->hasMany('App\DosenPembimbingSkripsi', 'dosbing_satu_skripsi');
    }

    // relasi 1-N dengan dosen_pembimbing
    public function dosbingDuaSkripsi(){
        return $this->hasMany('App\DosenPembimbingSkripsi', 'dosbing_dua_skripsi');
    }

    // relasi 1-N dengan dosen_pembimbing_kp
    public function dosbingSatuKp(){
        return $this->hasMany('App\DosenPembimbingKp', 'dosbing_satu_kp');
    }

    // relasi 1-N dengan dosen_pembimbing
    public function dosbingDuaKp(){
        return $this->hasMany('App\DosenPembimbingKp', 'dosbing_dua_kp');
    }

    // relasi 1-N dengan dosbing_mundur
    public function dosbingMundur(){
        return $this->hasMany('App\DosbingMundur', 'id_dosen');
    }

    // relasi 1-N dengan dosen_penguji
    public function dosenPenguji(){
        return $this->hasMany('App\DosenPenguji', 'id_dosen');
    }

    // relasi 1-N dengan penilaian_proposal
    public function dospengSatuProposal(){
        return $this->hasMany('App\PenilaianProposal', 'dospeng_satu_proposal');
    }

    // relasi 1-N dengan penilaian_proposal
    public function dospengDuaProposal(){
        return $this->hasMany('App\PenilaianProposal', 'dospeng_dua_proposal');
    }

    // relasi 1-N dengan penilaian_proposal
    public function dospengTigaProposal(){
        return $this->hasMany('App\PenilaianProposal', 'dospeng_tiga_proposal');
    }

    // relasi 1-N dengan penilaian_proposal
    public function dospengEmpatProposal(){
        return $this->hasMany('App\PenilaianProposal', 'dospeng_empat_proposal');
    }

    // relasi 1-N dengan penilaian_hasil
    public function dospengSatuHasil(){
        return $this->hasMany('App\PenilaianHasil', 'dospeng_satu_hasil');
    }

    // relasi 1-N dengan penilaian_hasil
    public function dospengDuaHasil(){
        return $this->hasMany('App\PenilaianHasil', 'dospeng_dua_hasil');
    }

    // relasi 1-N dengan penilaian_hasil
    public function dospengTigaHasil(){
        return $this->hasMany('App\PenilaianHasil', 'dospeng_tiga_hasil');
    }

    // relasi 1-N dengan penilaian_hasil
    public function dospengEmpatHasil(){
        return $this->hasMany('App\PenilaianHasil', 'dospeng_empat_hasil');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function dospengSatuSidang(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'dospeng_satu_sidang');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function dospengDuaSidang(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'dospeng_dua_sidang');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function dospengTigaSidang(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'dospeng_tiga_sidang');
    }

    // relasi 1-N dengan penilaian_sidang_skripsi
    public function dospengEmpatSidang(){
        return $this->hasMany('App\PenilaianSidangSkripsi', 'dospeng_empat_sidang');
    }

    // relasi 1-N dengan penilaian_kp
    public function penilaianKp(){
        return $this->hasMany('App\PenilaianKp', 'id_dosen');
    }

    // Relasi N-1 dengan prodi
    public function prodi(){
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    // relasi 1-N dengan aistensi
    public function asistensi(){
        return $this->hasMany('App\Asistensi', 'id_dosen');
    }

    // relasi 1-N dengan notifikasi_dosen
    public function notifikasiDosen(){
        return $this->hasMany('App\NotifikasiDosen', 'id_dosen');
    }

    // relasi 1-N dengan persetujuan_ujian
    public function dosbingSatuAproval(){
        return $this->hasMany('App\PersetujuanUjian', 'dosbing_satu_aproval');
    }

    // relasi 1-N dengan persetujuan_ujian
    public function dosbingDuaAproval(){
        return $this->hasMany('App\PersetujuanUjian', 'dosbing_dua_aproval');
    }

}
