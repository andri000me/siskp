<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JadwalUjianTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 50) as $index){
            DB::insert('insert into jadwal_ujian (ujian, tempat, waktu, id_mahasiswa) values (:ujian, :tempat, :waktu, :id_mahasiswa)',
            [
              'ujian' => $faker->randomElement(['proposal', 'kerja-praktik', 'hasil', 'sidang-skripsi']),
              'tempat' => $faker->randomElement(['Lab. Komputer 1', 'Perpustakaan Teknik', 'Jurusan', 'Lab. Komputer 2', 'Lab. Komputer 3']),
              'waktu' => $faker->dateTime(),
              'id_mahasiswa' => $faker->numberBetween(1, 100)
            ]);
        }
        $this->command->info('Berhasil Menambahkan 50 baris di tabel jadwal_ujian');
    }
}
