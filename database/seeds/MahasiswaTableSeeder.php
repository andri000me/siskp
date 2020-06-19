<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MahasiswaTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 100) as $index){
            DB::insert('insert into mahasiswa (nim, nama, password, angkatan, id_prodi, id_dosen, tahapan_kp, tahapan_skripsi, created_at, updated_at) values (:nim, :nama, :password, :angkatan, :id_prodi, :id_dosen, :tahapan_kp, :tahapan_skripsi, :created_at, :updated_at)',
            [
              'nim' => mt_rand(0000000001, 9999999999),
              'nama' => $faker->name,
              'password' => Hash::make('mahasiswa'),
              'angkatan' => mt_rand(2014, 2017),
              'id_prodi' => $faker->numberBetween(1, 2),
              'id_dosen' => $faker->numberBetween(1, 25),
              'tahapan_skripsi' => $faker->randomElement(['persiapan', 'pendaftaran_topik', 'penyusunan_proposal', 'pendaftaran_proposal', 'ujian_seminar_proposal', 'penulisan_skripsi', 'pendaftaran_hasil', 'ujian_seminar_hasil', 'revisi_skripsi', 'pendaftaran_sidang_skripsi', 'ujian_sidang_skripsi', 'lulus']), 
              'tahapan_kp' => $faker->randomElement(['persiapan', 'pendaftaran', 'ujian_seminar', 'revisi', 'lulus']), 
              'created_at' => now(),
              'updated_at' => now()
            ]);
        }
        $this->command->info('Berhasil Menambahkan 100 baris di tabel mahasiswa');
    }
}
