<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBimbinganTable extends Migration
{
    public function up()
    {
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('konsultasi');
            $table->date('waktu');
            $table->enum('bimbingan', [
                'kerja-praktek', 'proposal', 'hasil', 'sidang-skripsi'
            ]);

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_dosen')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bimbingan');
    }
}
