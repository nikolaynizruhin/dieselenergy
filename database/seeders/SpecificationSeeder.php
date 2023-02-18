<?php

namespace Database\Seeders;

use App\Models\Specification;
use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specification::factory()->count(3)->create();
    }
}
