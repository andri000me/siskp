<?php

use Illuminate\Database\Seeder;

class ProdiTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Sistem Informasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Pendidikan Teknologi Informasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('prodi')->insert($data);
        $this->command->info('Berhasil Menambahkan 2 baris di tabel prodi');
    }
}
