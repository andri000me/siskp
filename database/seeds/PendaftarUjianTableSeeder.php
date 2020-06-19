<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PendaftarUjianTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(26, 50) as $index){
            DB::insert('insert into pendaftar_ujian (id_mahasiswa, id_periode_daftar_ujian, ujian) values (:id_mahasiswa, :id_periode_daftar_ujian, :ujian)',
            [
            //   'id_mahasiswa' => $faker->numberBetween(1, 100),
              'id_mahasiswa' => $index,
              'id_periode_daftar_ujian' => $faker->numberBetween(1, 15),
              'ujian' => $faker->randomElement(['proposal', 'kerja-praktek', 'hasil', 'sidang-skripsi']),
            ]);
        }
        $this->command->info('Berhasil Menambahkan 50 baris di tabel pendaftar_ujian');
    }
}
