<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PeriodeDaftarUsulanTopikTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 15) as $index){
            DB::insert('insert into periode_daftar_usulan_topik (nama, waktu_buka, waktu_tutup, id_semester) values (:nama, :waktu_buka, :waktu_tutup, :id_semester)',
            [
              'nama' => $faker->monthName().' '.$faker->year(),
              'waktu_buka' => $faker->date(),
              'waktu_tutup' => $faker->date(),
              'id_semester' => 1
            ]);
        }
        $this->command->info('Berhasil Menambahkan 15 baris di tabel periode_daftar_usulan_topik');
    }
}
