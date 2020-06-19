<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianKp extends Migration
{
    public function up()
    {
        Schema::create('penilaian_kp', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('nilai', 5)->nullable();
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_indikator_penilaian')->unsigned()->nullable();
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_kp');
    }
}
