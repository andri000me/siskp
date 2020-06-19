<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKajurTable extends Migration
{
    public function up()
    {
        Schema::create('kajur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->year('tahun_awal');
            $table->year('tahun_selesai');
            $table->timestamps();
            
            // foreign key
            $table->bigInteger('id_dosen')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kajur');
    }
}
