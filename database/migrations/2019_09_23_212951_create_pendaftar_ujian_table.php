<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftarUjianTable extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->enum('ujian', [
                'kerja-praktek', 'proposal', 'hasil', 'sidang-skripsi'
            ]);
            $table->enum('tahapan', [
                'diperiksa', 'ditolak', 'diterima'
            ])->default('diperiksa');
            $table->string('keterangan', 255)->nullable();
            
            $table->text('judul_laporan_kp')->nullable();

            $table->string('file_laporan', 100)->nullable();   
            $table->string('file_lembar_persetujuan', 100)->nullable();
            
            $table->string('skor_toefl', 100)->nullable();   
            $table->string('file_sertifikat_toefl', 100)->nullable();
            
            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_periode_daftar_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_ujian');
    }
}
