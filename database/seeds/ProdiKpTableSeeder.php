<?php

use Illuminate\Database\Seeder;

class ProdiKpTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_prodi' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('prodi_kp')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 1 baris di tabel prodi_kp');
    }
}
