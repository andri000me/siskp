<?php

use Illuminate\Database\Seeder;

class SemesterTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Genap 2019/2020',
                'waktu_buka' => '2020-01-01',
                'waktu_tutup' => '2020-06-30',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('semester')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 1 baris di tabel semester');
    }
}
