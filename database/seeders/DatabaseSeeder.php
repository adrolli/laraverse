<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(CategorySeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ItemRelationSeeder::class);
        $this->call(ItemRelationTypeSeeder::class);
        $this->call(ItemTypeSeeder::class);
        $this->call(NpmPackageSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(PackagistPackageSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostTypeSeeder::class);
        $this->call(RepositorySeeder::class);
        $this->call(RepositoryTagSeeder::class);
        $this->call(RepositoryTypeSeeder::class);
        $this->call(StackSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VendorSeeder::class);
    }
}
