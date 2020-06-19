<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengaturanTable extends Migration
{
    public function up()
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // total referensi jurnal terkait
            $table->string('min_referensi_utama', 3);

            // max size file laporan
            $table->string('max_file_upload', 10);

            // panduan siskp
            $table->string('panduan_siskp', 100);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan');
    }
}
