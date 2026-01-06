<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            [
                'pemesanan_id' => 1,
                'metode_pembayaran' => 'Transfer Bank',
                'tanggal_bayar' => now(),
                'jumlah_bayar' => 900000,
                'status' => 'menunggu'
            ],
        ]);

    }
}
