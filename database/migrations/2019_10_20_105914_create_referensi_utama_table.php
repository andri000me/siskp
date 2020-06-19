<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferensiUtamaTable extends Migration
{
    public function up()
    {
        Schema::create('referensi_utama', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nama_penulis')->nullable();
            $table->text('judul_artikel')->nullable();
            $table->text('jurnal_ilmiah')->nullable();
            $table->text('keterkaitan')->nullable();

            $table->timestamps();
            
            // foreign key
            $table->bigInteger('id_pendaftar_usulan_topik')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referensi_utama');
    }
}
