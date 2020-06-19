<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(PengaturanTableSeeder::class);
        $this->call(ProdiTableSeeder::class);
        $this->call(ProdiKpTableSeeder::class);
        $this->call(DosenTableSeeder::class);
        $this->call(KajurTableSeeder::class);
        $this->call(KaprodiTableSeeder::class);
        $this->call(IndikatorPenilaianTableSeeder::class);
        $this->call(MahasiswaTableSeeder::class);

        // semester & periode
        $this->call(SemesterTableSeeder::class);
        $this->call(PeriodeDaftarUjianTableSeeder::class);
        $this->call(PeriodeDaftarUsulanTopikTableSeeder::class);
        $this->call(PeriodeDaftarTurunKpTableSeeder::class);

        // pendaftar
        $this->call(PendaftarUsulanTopikTableSeeder::class);
        $this->call(PendaftarTurunKpTableSeeder::class);
        $this->call(PendaftarUjianTableSeeder::class);
    }
}
