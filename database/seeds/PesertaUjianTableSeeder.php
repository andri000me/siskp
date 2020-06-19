<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PesertaUjianTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 75) as $index){
            DB::insert('insert into peserta_ujian (id_jadwal_ujian, id_mahasiswa) values (:id_jadwal_ujian, :id_mahasiswa)',
            [
              'id_jadwal_ujian' => $faker->numberBetween(1, 50),
              'id_mahasiswa' => $faker->numberBetween(1, 10),
            ]);
        }
        $this->command->info('Berhasil Menambahkan 75 baris di tabel peserta_ujian');
    }
}
