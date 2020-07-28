<?php

use Illuminate\Database\Seeder;

class PengaturanTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'min_referensi_utama' => '3',
                
                'max_file_upload' => '8192',
                
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('pengaturan')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 1 baris di tabel pengaturan');
    }
}
