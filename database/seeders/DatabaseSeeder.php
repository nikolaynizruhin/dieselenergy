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
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            SpecificationSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            PostSeeder::class,
        ]);
    }
}
