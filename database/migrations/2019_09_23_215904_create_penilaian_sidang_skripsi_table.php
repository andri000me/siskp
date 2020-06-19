<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianSidangSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('penilaian_sidang_skripsi', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('nilai_dospeng_satu', 5)->nullable();
            $table->string('nilai_dospeng_dua', 5)->nullable();
            $table->string('nilai_dospeng_tiga', 5)->nullable();
            $table->string('nilai_dospeng_empat', 5)->nullable();
            
            $table->string('nilai_rerata', 5)->nullable();
            $table->string('nilai_rerata_x_bobot', 5)->nullable();
            $table->timestamps();

            // foreign key
            $table->bigInteger('dospeng_satu_sidang')->unsigned()->nullable();
            $table->bigInteger('dospeng_dua_sidang')->unsigned()->nullable();
            $table->bigInteger('dospeng_tiga_sidang')->unsigned()->nullable();
            $table->bigInteger('dospeng_empat_sidang')->unsigned()->nullable();
            
            $table->bigInteger('id_indikator_penilaian')->unsigned()->nullable();
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_sidang_skripsi');
    }
}
