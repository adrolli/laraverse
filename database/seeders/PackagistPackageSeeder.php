<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackagistPackage;

class PackagistPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PackagistPackage::factory()
            ->count(5)
            ->create();
    }
}
