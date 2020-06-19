<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftarTurunKp extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_turun_kp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('instansi');
            $table->text('alamat');
            $table->string('file_lembar_persetujuan', 255)->nullable();
            $table->timestamps();

            $table->enum('tahapan', [
                'diperiksa', 'diterima', 'ditolak', 'dibatalkan'
            ])->default('diperiksa');
            $table->string('keterangan', 255)->nullable();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_periode_daftar_turun_kp')->unsigned()->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_turun_kp');
    }
}
