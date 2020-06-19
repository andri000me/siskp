<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PendaftarTurunKpTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(51, 100) as $index){
            DB::insert('insert into pendaftar_turun_kp (id_mahasiswa, id_periode_daftar_turun_kp, instansi, alamat, created_at, updated_at) values (:id_mahasiswa, :id_periode_daftar_turun_kp, :instansi, :alamat, :created_at, :updated_at)',
            [
              'id_mahasiswa' => $index,
              'id_periode_daftar_turun_kp' => $faker->numberBetween(1, 15),
              'instansi' => $faker->company,
              'alamat' => $faker->streetAddress,
              'created_at' => now(),
              'updated_at' => now()
            ]);
        }
        $this->command->info('Berhasil Menambahkan 50 baris di tabel pendaftar_turun_kp');
    }
}
