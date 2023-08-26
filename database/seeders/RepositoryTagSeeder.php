<?php

namespace Database\Seeders;

use App\Models\RepositoryTag;
use Illuminate\Database\Seeder;

class RepositoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RepositoryTag::factory()
            ->count(5)
            ->create();
    }
}
