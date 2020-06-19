<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim', 15);
            $table->string('nama', 255);
            $table->string('angkatan', 5);
            $table->string('password', 255);
            $table->string('token', 100)->nullable();

            $table->enum('tahapan_kp', [
                'persiapan', 'pendaftaran', 'ujian_seminar', 'revisi', 'lulus'
            ])->default('persiapan');
            $table->enum('tahapan_skripsi', [
                'persiapan', 'pendaftaran_topik', 'penyusunan_proposal', 'pendaftaran_proposal', 'ujian_seminar_proposal', 'penulisan_skripsi', 'pendaftaran_hasil', 'ujian_seminar_hasil', 'revisi_skripsi', 'pendaftaran_sidang_skripsi', 'ujian_sidang_skripsi', 'lulus'
            ])->default('persiapan');
            $table->timestamps();

            $table->enum('kontrak_kp', [
                'ya', 'tidak'
            ])->default('tidak');

            $table->enum('kontrak_skripsi', [
                'ya', 'tidak'
            ])->default('tidak');

            // foreign key
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            $table->bigInteger('id_prodi')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
