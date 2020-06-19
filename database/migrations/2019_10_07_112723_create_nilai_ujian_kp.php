<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianKp extends Migration
{
    public function up()
    {
        Schema::create('nilai_ujian_kp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('total', 5)->nullable();
            $table->string('nilai_huruf', 5)->nullable();
            $table->enum('status', ['lulus', 'tidak-lulus'])->nullable();
            $table->timestamps();
            
            // foreign key
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_ujian_kp');
    }
}
