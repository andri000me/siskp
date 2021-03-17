<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianProposalTable extends Migration
{
    public function up()
    {
        Schema::create('penilaian_proposal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nilai_dospeng_satu', 5)->nullable();
            $table->string('nilai_dospeng_dua', 5)->nullable();
            $table->string('nilai_dospeng_tiga', 5)->nullable();
            $table->string('nilai_dospeng_empat', 5)->nullable();
            $table->string('nilai_dospeng_lima', 5)->nullable();
            $table->string('nilai_rerata', 5)->nullable();
            $table->string('nilai_rerata_x_bobot', 5)->nullable();
            $table->timestamps();

            // foreign key
            $table->bigInteger('dospeng_satu_proposal')->unsigned()->nullable();
            $table->bigInteger('dospeng_dua_proposal')->unsigned()->nullable();
            $table->bigInteger('dospeng_tiga_proposal')->unsigned()->nullable();
            $table->bigInteger('dospeng_empat_proposal')->unsigned()->nullable();
            $table->bigInteger('dospeng_lima_proposal')->unsigned()->nullable();

            $table->bigInteger('id_indikator_penilaian')->unsigned()->nullable();
            $table->bigInteger('id_jadwal_ujian')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_proposal');
    }
}
