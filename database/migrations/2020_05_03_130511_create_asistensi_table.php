<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistensiTable extends Migration
{
    public function up()
    {
        Schema::create('asistensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('topik_bimbingan', 100);
            $table->enum('jenis', [
                'skripsi', 'kerja-praktek'
            ]);
            
            // foreign key
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistensi');
    }
}
