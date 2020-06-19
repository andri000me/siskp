<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PesertaUjianLamaTable extends Migration
{
    public function up()
    {
        Schema::create('peserta_ujian_lama', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim', 15);
            $table->string('nama', 255);
            $table->enum('ujian', [
                'proposal', 'hasil'
            ]);
            $table->date('tanggal');

            $table->timestamps();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        //
    }
}
