<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasilPlagiasiTable extends Migration
{
    public function up()
    {
        Schema::create('hasil_plagiasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('persentasi_plagiasi', 5);
            $table->string('file_hasil_plagiasi', 100);
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_pendaftar_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_plagiasi');
    }
}
