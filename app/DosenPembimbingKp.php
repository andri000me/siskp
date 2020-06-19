<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenPembimbingKp extends Model
{
    protected $table = 'dosen_pembimbing_kp';

    protected $guarded = [];

    public function scopeDosbing($query, $dosbing){
      return $query->where('dosbing', $dosbing);
    }

    public function scopeTahapSemester($query, $semester){
      return $query->where('id_semester', $semester);
    }

    // Relasi N-1 dengan mahasiswa
    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'id_mahasiswa');
    }

    // Relasi N-1 dengan semester
    public function semester(){
        return $this->belongsTo('App\Semester', 'id_semester');
    }

    // Relasi N-1 dengan dosen
    public function dosbingSatuKp(){
        return $this->belongsTo('App\Dosen', 'dosbing_satu_kp');
    }

    // Relasi N-1 dengan dosen
    public function dosbingDuaKp(){
        return $this->belongsTo('App\Dosen', 'dosbing_dua_kp');
    }

}
