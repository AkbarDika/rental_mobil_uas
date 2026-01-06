<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pemesanan')->insert([
            [
                'user_id' => 2,
                'tanggal_pesan' => now(),
                'tanggal_mulai' => now()->addDay(),
                'tanggal_selesai' => now()->addDays(3),
                'total_harga' => 900000,
                'status' => 'pending'
            ],
        ]);

    }
}
