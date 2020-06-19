<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosbingBerhalanganTable extends Migration
{
    public function up()
    {
        Schema::create('dosbing_berhalangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_semester')->unsigned()->nullable();
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            
            $table->enum('ujian', [
                'skripsi', 'kerja-praktek'
            ]);
            $table->enum('status', [
                'tidak-bersedia', 'mundur'
            ]);
            $table->string('dosbing', 5);
            $table->string('alasan', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosbing_berhalangan');
    }
}
