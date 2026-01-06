<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('mobil')->insert([
                'kategori_id' => rand(1,4),
                'merk' => 'Toyota',
                'model' => 'Avanza ' . $i,
                'tahun' => 2020,
                'nomor_plat' => 'B ' . rand(1000,9999) . ' XYZ',
                'harga_sewa' => 300000,
                'status' => 'tersedia'
            ]);
        }
    }
}
