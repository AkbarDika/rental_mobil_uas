<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_mobil')->insert([
            ['nama_kategori' => 'SUV'],
            ['nama_kategori' => 'MPV'],
            ['nama_kategori' => 'Sedan'],
            ['nama_kategori' => 'Pickup'],
        ]);

    }
}
