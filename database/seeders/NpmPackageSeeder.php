<?php

namespace Database\Seeders;

use App\Models\NpmPackage;
use Illuminate\Database\Seeder;

class NpmPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NpmPackage::factory()
            ->count(5)
            ->create();
    }
}
