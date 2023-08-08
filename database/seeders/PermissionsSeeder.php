<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'list items']);
        Permission::create(['name' => 'view items']);
        Permission::create(['name' => 'create items']);
        Permission::create(['name' => 'update items']);
        Permission::create(['name' => 'delete items']);

        Permission::create(['name' => 'list platforms']);
        Permission::create(['name' => 'view platforms']);
        Permission::create(['name' => 'create platforms']);
        Permission::create(['name' => 'update platforms']);
        Permission::create(['name' => 'delete platforms']);

        Permission::create(['name' => 'list stacks']);
        Permission::create(['name' => 'view stacks']);
        Permission::create(['name' => 'create stacks']);
        Permission::create(['name' => 'update stacks']);
        Permission::create(['name' => 'delete stacks']);

        Permission::create(['name' => 'list tags']);
        Permission::create(['name' => 'view tags']);
        Permission::create(['name' => 'create tags']);
        Permission::create(['name' => 'update tags']);
        Permission::create(['name' => 'delete tags']);

        Permission::create(['name' => 'list types']);
        Permission::create(['name' => 'view types']);
        Permission::create(['name' => 'create types']);
        Permission::create(['name' => 'update types']);
        Permission::create(['name' => 'delete types']);

        Permission::create(['name' => 'list vendors']);
        Permission::create(['name' => 'view vendors']);
        Permission::create(['name' => 'create vendors']);
        Permission::create(['name' => 'update vendors']);
        Permission::create(['name' => 'delete vendors']);

        Permission::create(['name' => 'list versions']);
        Permission::create(['name' => 'view versions']);
        Permission::create(['name' => 'create versions']);
        Permission::create(['name' => 'update versions']);
        Permission::create(['name' => 'delete versions']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
