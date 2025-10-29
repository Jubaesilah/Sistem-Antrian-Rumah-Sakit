<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AntrianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $antrian = [
            [
                'nomor_antrian' => 'A 145',
                'loket_id' => 1,
                'status' => 'dipanggil',
                'nama_pasien' => 'John Doe',
                'jenis_layanan' => 'Pendaftaran',
                'waktu_panggil' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_antrian' => 'A 146',
                'loket_id' => 2,
                'status' => 'dipanggil',
                'nama_pasien' => 'Jane Smith',
                'jenis_layanan' => 'Pendaftaran',
                'waktu_panggil' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_antrian' => 'A 144',
                'loket_id' => 3,
                'status' => 'dipanggil',
                'nama_pasien' => 'Bob Johnson',
                'jenis_layanan' => 'Pendaftaran',
                'waktu_panggil' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_antrian' => 'B 143',
                'loket_id' => 4,
                'status' => 'dipanggil',
                'nama_pasien' => 'Alice Brown',
                'jenis_layanan' => 'Pembayaran',
                'waktu_panggil' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_antrian' => 'B 098',
                'loket_id' => 5,
                'status' => 'dipanggil',
                'nama_pasien' => 'Charlie Wilson',
                'jenis_layanan' => 'Pembayaran',
                'waktu_panggil' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('antrian')->insert($antrian);
    }
}
