<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdiKpTable extends Migration
{
    public function up()
    {
        Schema::create('prodi_kp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_prodi')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prodi_kp');
    }
}
