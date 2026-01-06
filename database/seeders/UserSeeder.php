<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@mail.com',
                'password' => Hash::make('password'),
                'alamat' => 'Kantor Pusat',
                'no_hp' => '0811111111'
            ],
            [
                'role_id' => 3,
                'name' => 'Customer 1',
                'username' => 'customer1',
                'email' => 'customer1@mail.com',
                'password' => Hash::make('password'),
                'alamat' => 'Bandung',
                'no_hp' => '0822222222'
            ],
        ]);

    }
}
