<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DosenPembimbingTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 75) as $index){
            DB::insert('insert into dosen_pembimbing (id_mahasiswa, id_semester, dosbing, bersedia, dosbing_satu, dosbing_dua) values (:id_mahasiswa, :id_semester, :dosbing, :bersedia, :dosbing_satu, :dosbing_dua)',
            [
              'id_mahasiswa' => $index,
              'id_semester' => '1',
              'dosbing' => 'skripsi',
              'bersedia' => $faker->randomElement(['ya', 'tidak']),
              'dosbing_satu' => $faker->numberBetween(1, 10),
              'dosbing_dua' => $faker->numberBetween(11, 25)
            ]);
        }
        $this->command->info('Berhasil Menambahkan 75 baris di tabel dosen_pembimbing');
    }
}
