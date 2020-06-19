<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodeDaftarUjianTable extends Migration
{
    public function up()
    {
        Schema::create('periode_daftar_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100);
            $table->date('waktu_buka');
            $table->date('waktu_tutup');
            $table->timestamps();
            $table->string('nomor_undangan', 100)->nullable();
            
            // foreign key
            $table->bigInteger('id_semester')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('periode_daftar_ujian');
    }
}
