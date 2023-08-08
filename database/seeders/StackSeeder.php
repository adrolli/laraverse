<?php

namespace Database\Seeders;

use App\Models\Stack;
use Illuminate\Database\Seeder;

class StackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stack::factory()
            ->count(5)
            ->create();
    }
}
