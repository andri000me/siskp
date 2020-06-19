<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenTable extends Migration
{
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip', 50);
            $table->string('nama', 255);
            $table->string('password', 255);
            $table->string('token', 100)->nullable();
            $table->string('tanda_tangan', 100)->nullable();
            $table->enum('status', [
                'aktif', 'tidak-aktif', 'cuti'
            ])->default('aktif');
            $table->enum('bisa_menguji', [
                'ya', 'tidak'
            ])->default('tidak');
            $table->enum('bisa_membimbing', [
                'ya', 'tidak'
            ])->default('tidak');
            $table->timestamps();

            // foreign key
            $table->bigInteger('id_prodi')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen');
    }
    
}
