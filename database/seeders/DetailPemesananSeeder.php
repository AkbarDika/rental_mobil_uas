<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_pemesanan')->insert([
            [
                'pemesanan_id' => 1,
                'mobil_id' => 1,
                'lama_sewa' => 3,
                'harga_per_hari' => 300000,
                'subtotal' => 900000
            ],
        ]);

    }
}
