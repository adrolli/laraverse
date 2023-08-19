<?php

namespace Database\Seeders;

use App\Models\GithubTag;
use Illuminate\Database\Seeder;

class GithubTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GithubTag::factory()
            ->count(5)
            ->create();
    }
}
