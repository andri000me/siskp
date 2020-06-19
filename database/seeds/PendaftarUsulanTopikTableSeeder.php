<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PendaftarUsulanTopikTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 25) as $index){
            DB::insert('insert into pendaftar_usulan_topik (id_mahasiswa, id_periode_daftar_usulan_topik, manfaat, tujuan, permasalahan, alternatif_judul, usulan_judul, usulan_topik, created_at, updated_at) values (:id_mahasiswa, :id_periode_daftar_usulan_topik, :manfaat, :tujuan, :permasalahan, :alternatif_judul, :usulan_judul, :usulan_topik, :created_at, :updated_at)',
            [
              'id_mahasiswa' => $index,
              'id_periode_daftar_usulan_topik' => $faker->numberBetween(1, 15),
              'manfaat' => $faker->sentence(10, true),
              'tujuan' => $faker->sentence(3, true),
              'permasalahan' => $faker->sentence(25, true),
              'alternatif_judul' => $faker->sentence(10, true),
              'usulan_judul' => $faker->sentence(50, true),
              'usulan_topik' => $faker->sentence(5, true),
              'created_at' => now(),
              'updated_at' => now()
            ]);
        }
        $this->command->info('Berhasil Menambahkan 25 baris di tabel pendaftar_usulan_topik');
    }
}
