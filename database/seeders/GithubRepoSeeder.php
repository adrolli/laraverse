<?php

namespace Database\Seeders;

use App\Models\GithubRepo;
use Illuminate\Database\Seeder;

class GithubRepoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GithubRepo::factory()
            ->count(5)
            ->create();
    }
}
