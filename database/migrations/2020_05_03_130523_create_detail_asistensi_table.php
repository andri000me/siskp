<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailAsistensiTable extends Migration
{
    public function up()
    {
        Schema::create('detail_asistensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->text('isi');
            $table->string('file', 100)->nullable();
            $table->string('is_dosen', 3)->nullable();
            $table->string('is_mahasiswa', 3)->nullable();
            
            // foreign key
            $table->bigInteger('id_asistensi')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_asistensi');
    }
}
