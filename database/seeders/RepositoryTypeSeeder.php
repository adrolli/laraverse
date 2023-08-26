<?php

namespace Database\Seeders;

use App\Models\RepositoryType;
use Illuminate\Database\Seeder;

class RepositoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RepositoryType::factory()
            ->count(5)
            ->create();
    }
}
