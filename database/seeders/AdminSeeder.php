<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'status' => 'inactive',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ensure you hash the password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
