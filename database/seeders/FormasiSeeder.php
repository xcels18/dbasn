<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formasis')->truncate();

        DB::table('formasis')->insert([
            [
                'nama_jabatan' => 'Auditor Ahli Madya',
                'kebutuhan' => 4,
                'kelas_jabatan' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Auditor Ahli Muda',
                'kebutuhan' => 6,
                'kelas_jabatan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Auditor Ahli Pertama',
                'kebutuhan' => 8,
                'kelas_jabatan' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'PPUPD Ahli Madya',
                'kebutuhan' => 3,
                'kelas_jabatan' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'PPUPD Ahli Muda',
                'kebutuhan' => 5,
                'kelas_jabatan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Analis SDM Aparatur',
                'kebutuhan' => 3,
                'kelas_jabatan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
