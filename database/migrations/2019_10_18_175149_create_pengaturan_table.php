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
            
            $table->string('max_file_upload', 10);

            // pendaftar usulan topik
            $table->string('min_referensi_utama', 3);

            $table->enum('skor_sertifikat_kompetensi', [
                'wajib', 'tidak-wajib', 'hilangkan'
            ])->default('hilangkan');


            // pendaftar turun kp 
            $table->enum('scan_persetujuan_kantor', [
                'wajib', 'tidak-wajib', 'hilangkan'
            ])->default('hilangkan');
            

            // pendaftar ujian
            $table->enum('skor_sertifikat_toefl', [
                'wajib', 'tidak-wajib', 'hilangkan'
            ])->default('hilangkan');

            $table->enum('file_laporan', [
                'wajib', 'tidak-wajib', 'hilangkan'
            ])->default('hilangkan');

            $table->enum('persetujuan_ujian', [
                'wajib', 'tidak-wajib', 'hilangkan'
            ])->default('hilangkan');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan');
    }
}
