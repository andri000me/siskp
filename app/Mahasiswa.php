<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $guarded = [];

    // Relasi N-1 dengan prodi
    public function prodi(){
        return $this->belongsTo('App\Prodi', 'id_prodi');
    }

    // Relasi N-1 dengan dosen
    public function dosen(){
        return $this->belongsTo('App\Dosen', 'id_dosen');
    }

    // relasi 1-N dengan bimbingan
    public function bimbingan(){
        return $this->hasMany('App\Bimbingan', 'id_mahasiswa');
    }

    // relasi 1-N dengan pendaftar_turun_kp
    public function pendaftarTurunKp(){
        return $this->hasMany('App\PendaftarTurunKp', 'id_mahasiswa');
    }
    
    // relasi 1-N dengan pendaftar_usulan_topik
    public function pendaftarUsulanTopik(){
        return $this->hasMany('App\PendaftarUsulanTopik', 'id_mahasiswa');
    }

    // relasi 1-N dengan pendaftar_ujian_proposal
    public function pendaftarUjian(){
        return $this->hasMany('App\PendaftarUjian', 'id_mahasiswa');
    }

    // relasi 1-N dengan peserta_ujian
    public function pesertaUjian(){
        return $this->hasMany('App\PesertaUjian', 'id_mahasiswa');
    }

    // relasi 1-N dengan peserta_ujian_lama
    public function pesertaUjianLama(){
        return $this->hasMany('App\PesertaUjianLama', 'id_mahasiswa');
    }

    // relasi 1-N dengan dosen_pembimbing
    public function dosenPembimbingSkripsi(){
        return $this->hasMany('App\DosenPembimbingSkripsi', 'id_mahasiswa');
    }

    // relasi 1-N dengan dosen_pembimbing
    public function dosenPembimbingKp(){
        return $this->hasMany('App\DosenPembimbingKp', 'id_mahasiswa');
    }

    // relasi 1-N dengan jadwal_ujian
    public function jadwalUjian(){
        return $this->hasMany('App\JadwalUjian', 'id_mahasiswa');
    }

    // relasi 1-N dengan nilai_ujian_skripsi
    public function nilaiUjianSkripsi(){
        return $this->hasMany('App\NilaiUjianSkripsi', 'id_mahasiswa');
    }

    // relasi 1-N dengan hasil_akumulasi_nilai_skripsi
    public function hasilAkumulasiNilaiSkripsi(){
        return $this->hasMany('App\HasilAkumulasiNilaiSkripsi', 'id_mahasiswa');
    }

    // relasi 1-N dengan riwayat_skripsi
    public function riwayatSkripsi(){
        return $this->hasMany('App\RiwayatSkripsi', 'id_mahasiswa');
    }

    // relasi 1-N dengan riwayat_tahapan
    public function riwayatTahapan(){
        return $this->hasMany('App\RiwayatTahapan', 'id_mahasiswa');
    }

    // relasi 1-N dengan asistensi
    public function asistensi(){
        return $this->hasMany('App\Asistensi', 'id_mahasiswa');
    }

    // relasi 1-N dengan notifikasi_mahasiswa
    public function notifikasiMahasiswa(){
        return $this->hasMany('App\NotifikasiMahasiswa', 'id_mahasiswa');
    }

    // relasi 1-N dengan persetujuan_ujian
    public function persetujuanUjian(){
        return $this->hasMany('App\PersetujuanUjian', 'id_mahasiswa');
    }

    // accessor nama mahasiswa dengan format Capitalize
    public function getNamaAttribute($value){
        return ucwords(strtolower($value));
    }
}
