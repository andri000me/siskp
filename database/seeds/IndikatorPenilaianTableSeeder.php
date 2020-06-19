<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IndikatorPenilaianTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'penyajian materi presentasi', 'ujian' => 'proposal', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'penguasaan materi', 'ujian' => 'proposal', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'isi proposal', 'ujian' => 'proposal', 'bobot' => '30', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'rancangan penelitian', 'ujian' => 'proposal', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'orisinalitas', 'ujian' => 'proposal', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],

            [
                'nama' => 'penyajian materi presentasi', 'ujian' => 'hasil', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'pendahuluan', 'ujian' => 'hasil', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'tinjauan pustaka', 'ujian' => 'hasil', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'metode penelitian', 'ujian' => 'hasil', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'hasil dan pembahasan', 'ujian' => 'hasil', 'bobot' => '40', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'kesimpulan dan saran', 'ujian' => 'hasil', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],

            [
                'nama' => 'penyajian materi presentasi', 'ujian' => 'sidang-skripsi', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'pendahuluan', 'ujian' => 'sidang-skripsi', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'tinjauan pustaka', 'ujian' => 'sidang-skripsi', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'metode penelitian', 'ujian' => 'sidang-skripsi', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'hasil dan pembahasan', 'ujian' => 'sidang-skripsi', 'bobot' => '30', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'kesimpulan dan saran', 'ujian' => 'sidang-skripsi', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '5', 'created_at' => now(), 'updated_at' => now()
            ],

            [
                'nama' => 'teknik presentasi', 'ujian' => 'kerja-praktek', 'bobot' => '10', 'nilai_min' => '1', 'nilai_max' => '100', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'penulisan laporan', 'ujian' => 'kerja-praktek', 'bobot' => '15', 'nilai_min' => '1', 'nilai_max' => '100', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'analisis dan perancangan', 'ujian' => 'kerja-praktek', 'bobot' => '20', 'nilai_min' => '1', 'nilai_max' => '100', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'penguasaan program', 'ujian' => 'kerja-praktek', 'bobot' => '25', 'nilai_min' => '1', 'nilai_max' => '100', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nama' => 'kualitas jawaban', 'ujian' => 'kerja-praktek', 'bobot' => '30', 'nilai_min' => '1', 'nilai_max' => '100', 'created_at' => now(), 'updated_at' => now()
            ]
        ];

        DB::table('indikator_penilaian')->insert($data);
        
        $this->command->info('Berhasil Menambahkan 22 baris di tabel indikator_penilaian');
    }
}
