<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterTable extends Migration
{
    public function up()
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100);
            $table->date('waktu_buka');
            $table->date('waktu_tutup');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semester');
    }
}
