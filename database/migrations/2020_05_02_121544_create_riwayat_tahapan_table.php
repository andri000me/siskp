<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiwayatTahapanTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_tahapan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('tahapan', 100);

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_tahapan');
    }
}
