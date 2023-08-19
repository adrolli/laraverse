<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GithubOrganization;

class GithubOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GithubOrganization::factory()
            ->count(5)
            ->create();
    }
}
