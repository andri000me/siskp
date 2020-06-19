<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenPembimbingKpTable extends Migration
{
    public function up()
    {
        Schema::create('dosen_pembimbing_kp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('lokasi', 255);

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_semester')->unsigned()->nullable();
            $table->bigInteger('dosbing_satu_kp')->unsigned()->nullable();
            $table->bigInteger('dosbing_dua_kp')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_pembimbing_kp');
    }
}
