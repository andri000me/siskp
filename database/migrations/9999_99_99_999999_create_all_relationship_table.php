<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllRelationshipTable extends Migration
{
    public function up()
    {
        // kajur w/ dosen
        Schema::table('kajur', function(Blueprint $table){
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // kaprodi w/ prodi & dosen
        Schema::table('kaprodi', function(Blueprint $table){
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // prodi_kp w/ prodi 
        Schema::table('prodi_kp', function(Blueprint $table){
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null')->onUpdate('cascade');
        });

        // mahasiswa w/ prodi & dosen pa
        Schema::table('mahasiswa', function(Blueprint $table){
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // bimbingan w/ mahasiswa & dosen
        Schema::table('bimbingan', function(Blueprint $table){
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
        });

        // periode_daftar_turun_kp w/ semester
        Schema::table('periode_daftar_turun_kp', function(Blueprint $table){
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
        });

        // periode_daftar_usulan_topik w/ semester
        Schema::table('periode_daftar_usulan_topik', function(Blueprint $table){
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
        });

        // periode_daftar_ujian w/ semester
        Schema::table('periode_daftar_ujian', function(Blueprint $table){
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
        });

        // pendaftar_turun_kp w/ mahasiswa & periode_daftar_turun_kp
        Schema::table('pendaftar_turun_kp', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_periode_daftar_turun_kp')->references('id')->on('periode_daftar_turun_kp')->onDelete('set null')->onUpdate('cascade');
        });
        
        // pendaftar_usulan_topik w/ mahasiswa & periode_daftar_usulan_topik
        Schema::table('pendaftar_usulan_topik', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_periode_daftar_usulan_topik')->references('id')->on('periode_daftar_usulan_topik')->onDelete('set null')->onUpdate('cascade');
        });

        // referensi_utama w/ pendaftar_usulan_topik
        Schema::table('referensi_utama', function(Blueprint $table){
            $table->foreign('id_pendaftar_usulan_topik')->references('id')->on('pendaftar_usulan_topik')->onDelete('cascade')->onUpdate('cascade');
        });

        // pendaftar_ujian w/ mahasiswa & periode_daftar_ujian
        Schema::table('pendaftar_ujian', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_periode_daftar_ujian')->references('id')->on('periode_daftar_ujian')->onDelete('set null')->onUpdate('cascade');
        });

        // peserta_ujian_lama w/ mahasiswa 
        Schema::table('peserta_ujian_lama', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
        });

        // hasil_plagiasi w/ pendaftaran_ujian
        Schema::table('hasil_plagiasi', function(Blueprint $table){
            $table->foreign('id_pendaftar_ujian')->references('id')->on('pendaftar_ujian')->onDelete('set null')->onUpdate('cascade');
        });

        // dosen_pembimbing_skripsi w/ mahasiswa, semester, & dosen
        Schema::table('dosen_pembimbing_skripsi', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dosbing_satu_skripsi')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dosbing_dua_skripsi')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // dosen_pembimbing_kp w/ mahasiswa, semester, & dosen
        Schema::table('dosen_pembimbing_kp', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dosbing_satu_kp')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dosbing_dua_kp')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // dosbing_berhalangan w/ mahasiswa, semester, & dosen
        Schema::table('dosbing_berhalangan', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
        });

        // jadwal_ujian w/ mahasiswa
        Schema::table('jadwal_ujian', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
        });

        // dosen_penguji w/ dosen & jadwal_ujian
        Schema::table('dosen_penguji', function(Blueprint $table){
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
        });

        // peserta_ujian w/ mahasiswa & jadwal_ujian
        Schema::table('peserta_ujian', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
        });

        // penilaian_proposal w/ mahasiswa & dosen
        Schema::table('penilaian_proposal', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dospeng_satu_proposal')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_dua_proposal')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_tiga_proposal')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_empat_proposal')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_indikator_penilaian')->references('id')->on('indikator_penilaian')->onDelete('set null')->onUpdate('cascade');
        });

        // penilaian_hasil w/ mahasiswa & dosen
        Schema::table('penilaian_hasil', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dospeng_satu_hasil')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_dua_hasil')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_tiga_hasil')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_empat_hasil')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_indikator_penilaian')->references('id')->on('indikator_penilaian')->onDelete('set null')->onUpdate('cascade');
        });

        // penilaian_sidang_skripsi w/ mahasiswa & dosen
        Schema::table('penilaian_sidang_skripsi', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dospeng_satu_sidang')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_dua_sidang')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_tiga_sidang')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dospeng_empat_sidang')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_indikator_penilaian')->references('id')->on('indikator_penilaian')->onDelete('set null')->onUpdate('cascade');
        });

        // penilaian_kp w/ mahasiswa & dosen
        Schema::table('penilaian_kp', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_indikator_penilaian')->references('id')->on('indikator_penilaian')->onDelete('set null')->onUpdate('cascade');
        });

        // nilai_ujian_skripsi w/ mahasiswa
        Schema::table('nilai_ujian_skripsi', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
        });

        // hasil_akumulasi_nilai_skripsi w/ mahasiswa
        Schema::table('hasil_akumulasi_nilai_skripsi', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
        });

        // nilai_ujian_kp w/ jadwal_ujian
        Schema::table('nilai_ujian_kp', function(Blueprint $table){
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian')->onDelete('cascade')->onUpdate('cascade');
        });

        // dosen w/ prodi 
        Schema::table('dosen', function(Blueprint $table){
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null')->onUpdate('cascade');
        });

        // riwayat_skripsi w/ mahasiswa 
        Schema::table('riwayat_skripsi', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('set null')->onUpdate('cascade');
        });

        // riwayat_tahapan w/ mahasiswa 
        Schema::table('riwayat_tahapan', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
        });

        // asistensi w/ mahasiswa & dosen
        Schema::table('asistensi', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
        });

        // detail_asistensi w/ asistensi 
        Schema::table('detail_asistensi', function(Blueprint $table){
            $table->foreign('id_asistensi')->references('id')->on('asistensi')->onDelete('cascade')->onUpdate('cascade');
        });

        // notifikasi_dosen w/ dosen 
        Schema::table('notifikasi_dosen', function(Blueprint $table){
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
        });

        // notifikasi_mahasiswa w/ mahasiswa 
        Schema::table('notifikasi_mahasiswa', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
        });

        // persetujuan_ujian w/ mahasiswa & dosen 
        Schema::table('persetujuan_ujian', function(Blueprint $table){
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosbing_satu_aproval')->references('id')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dosbing_dua_aproval')->references('id')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('all_relationship');
    }
}
