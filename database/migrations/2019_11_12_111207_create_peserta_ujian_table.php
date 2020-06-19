<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesertaUjianTable extends Migration
{
    public function up()
    {
        Schema::create('peserta_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peserta_ujian');
    }
}
