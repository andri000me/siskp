<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiwayatSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_skripsi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_jurnal_skripsi', 100)->nullable();
            
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_skripsi');
    }
}
