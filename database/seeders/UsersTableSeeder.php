<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'roles' => 'ADMIN',
        ]);

        DB::table('users')->insert([
            'name' => 'Dicky',
            'email' => 'dicky@gmail.com',
            'password' => Hash::make('12345678'),
            'roles' => 'OWNER',
        ]);
    }
}
