<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nama_role' => 'Super Admin', 'deskripsi' => 'Akses penuh'],
            ['nama_role' => 'Admin', 'deskripsi' => 'Kelola data'],
            ['nama_role' => 'Customer', 'deskripsi' => 'Penyewa mobil'],
            ['nama_role' => 'Petugas', 'deskripsi' => 'Validasi transaksi'],
        ]);

    }
}
