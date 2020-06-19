<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('nilai_ujian_skripsi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jumlah_nilai', 5)->nullable();
            $table->string('nilai_akhir', 5)->nullable();
            $table->enum('status', ['lulus', 'tidak-lulus'])->nullable();
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_ujian_skripsi');
    }
}
