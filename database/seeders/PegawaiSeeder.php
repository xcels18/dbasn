<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $jabatanList = [
            'Inspektur Daerah', 'Sekretaris Inspektorat', 'Inspektur Pembantu Wilayah I', 
            'Inspektur Pembantu Wilayah II', 'Inspektur Pembantu Wilayah III', 
            'Inspektur Pembantu Wilayah Khusus', 'Auditor Ahli Utama', 
            'Auditor Ahli Madya', 'Auditor Ahli Muda', 'Auditor Ahli Pertama', 
            'Auditor Terampil', 'PPUPD Ahli Madya', 'PPUPD Ahli Muda', 
            'PPUPD Ahli Pertama', 'Analis SDM Aparatur', 'Arsiparis', 'Pranata Keuangan'
        ];

        $unitKerjaList = [
            'Sekretariat Utama', 'Inspektur Pembantu Wilayah I', 
            'Inspektur Pembantu Wilayah II', 'Inspektur Pembantu Wilayah III', 
            'Inspektur Pembantu Wilayah Khusus'
        ];

        $pangkatList = [
            'Pengatur Muda (II/a)', 'Pengatur Muda Tk. I (II/b)', 'Pengatur (II/c)', 'Pengatur Tk. I (II/d)',
            'Penata Muda (III/a)', 'Penata Muda Tk. I (III/b)', 'Penata (III/c)', 'Penata Tk. I (III/d)',
            'Pembina (IV/a)', 'Pembina Tk. I (IV/b)', 'Pembina Utama Muda (IV/c)', 'Pembina Utama Madya (IV/d)'
        ];

        $pendidikanList = ['SMA/Sederajat', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $agamaList = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha'];
        $statusList = ['Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Cuti', 'Tugas Belajar'];

        // Truncate the table before inserting to prevent collision and duplicates
        DB::table('pegawais')->truncate();

        $pegawais = [];

        for ($i = 0; $i < 51; $i++) {
            $pegawais[] = [
                'nip' => $faker->unique()->numerify('19########20######'),
                'nama' => $faker->name,
                'nik' => $faker->unique()->numerify('91040###########'),
                'kk' => $faker->numerify('91040###########'),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'agama' => $faker->randomElement($agamaList),
                'jabatan' => $faker->randomElement($jabatanList),
                'unit_kerja' => $faker->randomElement($unitKerjaList),
                'pangkat_golongan' => $faker->randomElement($pangkatList),
                'pendidikan_terakhir' => $faker->randomElement($pendidikanList),
                'status' => $faker->randomElement($statusList),
                'latitude' => $faker->randomFloat(6, -3.760000, -3.740000), // Around Mulia, Puncak Jaya
                'longitude' => $faker->randomFloat(6, 137.940000, 137.960000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Chunk insert to avoid too many parameters error in PDO
        foreach (array_chunk($pegawais, 50) as $chunk) {
            DB::table('pegawais')->insert($chunk);
        }
    }
}
