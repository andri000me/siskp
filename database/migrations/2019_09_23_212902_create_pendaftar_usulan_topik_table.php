<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftarUsulanTopikTable extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_usulan_topik', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->text('usulan_topik')->nullable();
            $table->text('usulan_judul')->nullable();
            $table->text('alternatif_judul')->nullable();
            $table->text('permasalahan')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('manfaat')->nullable();
            $table->text('metode_penelitian')->nullable();
            $table->text('metode_pengembangan_sistem')->nullable();
            $table->text('tahapan_penelitian')->nullable();
            $table->timestamps();

            $table->enum('tahapan', [
                'diperiksa', 'diterima', 'ditolak', 'dibatalkan'
            ])->default('diperiksa');
            $table->string('keterangan', 255)->nullable();

            // foreign key
            $table->bigInteger('id_mahasiswa')->unsigned()->nullable();
            $table->bigInteger('id_periode_daftar_usulan_topik')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_usulan_topik');
    }
}
