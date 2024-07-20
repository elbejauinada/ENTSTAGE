<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call the AdminSeeder
        $this->call([
            AdminSeeder::class,
            // You can add other seeders here as well
        ]);

        // If you have other seeders, you can call them like this:
        // $this->call(UserSeeder::class);
        // $this->call(PostSeeder::class);
    }
}
