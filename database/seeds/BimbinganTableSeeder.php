<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BimbinganTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 25) as $index){
            DB::insert('insert into bimbingan (id_mahasiswa, id_dosen, bimbingan, konsultasi, waktu) values (:id_mahasiswa, :id_dosen, :bimbingan, :konsultasi, :waktu)',
            [
              'id_mahasiswa' => $faker->numberBetween(1, 10),
              'id_dosen' => $faker->numberBetween(1, 25),
              'bimbingan' => $faker->randomElement(['skripsi', 'kerja-praktek']),
              'konsultasi' => $faker->sentence(10, true),
              'waktu' => now()
            ]);
        }
        $this->command->info('Berhasil Menambahkan 25 baris di tabel bimbingan');
    }
}
