<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Alf Drollinger',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
    }
}
