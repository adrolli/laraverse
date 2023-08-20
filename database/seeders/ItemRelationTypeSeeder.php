<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemRelationType;

class ItemRelationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemRelationType::factory()
            ->count(5)
            ->create();
    }
}
