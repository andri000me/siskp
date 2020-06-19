<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasilAkumulasiNilaiSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('hasil_akumulasi_nilai_skripsi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seminar_proposal', 5)->nullable();
            $table->string('seminar_hasil', 5)->nullable();
            $table->string('sidang_skripsi', 5)->nullable();
            $table->string('total', 5)->nullable();
            $table->string('nilai_huruf', 5)->nullable();
            $table->timestamps();
            
            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_akumulasi_nilai_skripsi');
    }
}
