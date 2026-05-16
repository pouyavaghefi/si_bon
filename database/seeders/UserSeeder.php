<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'name' => 'root',
            'mobile' => '0000000000',
            'email' => 'root@pouyait.nl',
            'password' => bcrypt('Godfather1'),
            'is_admin' => 1,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('members')->insert([
            'user_id' => $userId,
            'first_name' => 'Admin',
            'last_name' => 'User',
            'newsletter' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
