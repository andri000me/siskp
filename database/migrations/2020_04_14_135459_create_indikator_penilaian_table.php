<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndikatorPenilaianTable extends Migration
{
    public function up()
    {
        Schema::create('indikator_penilaian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 255);
            $table->enum('ujian', ['kerja-praktek', 'proposal', 'hasil', 'sidang-skripsi']);
            $table->string('bobot', 5);
            $table->string('nilai_min', 5);
            $table->string('nilai_max', 5);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indikator_penilaian');
    }
}
