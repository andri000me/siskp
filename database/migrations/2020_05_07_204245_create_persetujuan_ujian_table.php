<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersetujuanUjianTable extends Migration
{
    public function up()
    {
        Schema::create('persetujuan_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('status_dosbing_satu', [
                'belum-diperiksa', 'disetujui', 'tidak-disetujui'
            ])->default('belum-diperiksa');
            $table->enum('status_dosbing_dua', [
                'belum-diperiksa', 'disetujui', 'tidak-disetujui'
            ])->default('belum-diperiksa');
            $table->enum('ujian', [
                'kerja-praktek', 'proposal', 'hasil', 'sidang-skripsi'
            ]);

            // foreign key
            $table->bigInteger('dosbing_satu_aproval')->unsigned()->nullable();
            $table->bigInteger('dosbing_dua_aproval')->unsigned()->nullable();
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persetujuan_ujian');
    }
}
