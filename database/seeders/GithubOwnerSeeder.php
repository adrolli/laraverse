<?php

namespace Database\Seeders;

use App\Models\GithubOwner;
use Illuminate\Database\Seeder;

class GithubOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GithubOwner::factory()
            ->count(5)
            ->create();
    }
}
