<?php

use Illuminate\Database\Seeder;

class KaprodiTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_dosen' => '14',
                'id_prodi' => '1',
                'tahun_awal' => '2019',
                'tahun_selesai' => '2023',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dosen' => '10',
                'id_prodi' => '2',
                'tahun_awal' => '2019',
                'tahun_selesai' => '2023',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('kaprodi')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 2 baris di tabel kaprodi');
    }
}
