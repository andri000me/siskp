<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenPembimbingSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('dosen_pembimbing_skripsi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_semester')->unsigned()->nullable();
            $table->bigInteger('dosbing_satu_skripsi')->unsigned()->nullable();
            $table->bigInteger('dosbing_dua_skripsi')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_pembimbing_skripsi');
    }
}
