<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Ayu', 'username' => 'ayu', 'password' => Hash::make('ayu'), 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Adnan', 'username' => 'adnan', 'password' => Hash::make('adnan'), 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('admin')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 2 baris di tabel admin');
    }
}
