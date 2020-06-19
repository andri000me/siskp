<?php

use Illuminate\Database\Seeder;

class KajurTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_dosen' => '18',
                'tahun_awal' => '2019',
                'tahun_selesai' => '2023',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('kajur')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 1 baris di tabel kajur');
    }
}
