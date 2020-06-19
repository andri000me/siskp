<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodeDaftarUsulanTopikTable extends Migration
{
    public function up()
    {
        Schema::create('periode_daftar_usulan_topik', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100);
            $table->date('waktu_buka');
            $table->date('waktu_tutup');
            $table->timestamps();
            
            // foreign key
            $table->bigInteger('id_semester')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('periode_daftar_usulan_topik');
    }
}
