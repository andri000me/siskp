<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenPengujiTable extends Migration
{
    public function up()
    {
        Schema::create('dosen_penguji', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dospeng', 10);

            $table->timestamps();

            // foreign key
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_penguji');
    }
}
