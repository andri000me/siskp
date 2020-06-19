<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalUjianTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('ujian', ['kerja-praktek', 'proposal', 'hasil', 'sidang-skripsi']);
            $table->string('tempat', 100);
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_ujian');
    }
}
