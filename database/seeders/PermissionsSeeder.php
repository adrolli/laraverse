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

        Permission::create(['name' => 'list itemrelations']);
        Permission::create(['name' => 'view itemrelations']);
        Permission::create(['name' => 'create itemrelations']);
        Permission::create(['name' => 'update itemrelations']);
        Permission::create(['name' => 'delete itemrelations']);

        Permission::create(['name' => 'list itemrelationtypes']);
        Permission::create(['name' => 'view itemrelationtypes']);
        Permission::create(['name' => 'create itemrelationtypes']);
        Permission::create(['name' => 'update itemrelationtypes']);
        Permission::create(['name' => 'delete itemrelationtypes']);

        Permission::create(['name' => 'list itemtypes']);
        Permission::create(['name' => 'view itemtypes']);
        Permission::create(['name' => 'create itemtypes']);
        Permission::create(['name' => 'update itemtypes']);
        Permission::create(['name' => 'delete itemtypes']);

        Permission::create(['name' => 'list npmpackages']);
        Permission::create(['name' => 'view npmpackages']);
        Permission::create(['name' => 'create npmpackages']);
        Permission::create(['name' => 'update npmpackages']);
        Permission::create(['name' => 'delete npmpackages']);

        Permission::create(['name' => 'list organizations']);
        Permission::create(['name' => 'view organizations']);
        Permission::create(['name' => 'create organizations']);
        Permission::create(['name' => 'update organizations']);
        Permission::create(['name' => 'delete organizations']);

        Permission::create(['name' => 'list owners']);
        Permission::create(['name' => 'view owners']);
        Permission::create(['name' => 'create owners']);
        Permission::create(['name' => 'update owners']);
        Permission::create(['name' => 'delete owners']);

        Permission::create(['name' => 'list packagistpackages']);
        Permission::create(['name' => 'view packagistpackages']);
        Permission::create(['name' => 'create packagistpackages']);
        Permission::create(['name' => 'update packagistpackages']);
        Permission::create(['name' => 'delete packagistpackages']);

        Permission::create(['name' => 'list platforms']);
        Permission::create(['name' => 'view platforms']);
        Permission::create(['name' => 'create platforms']);
        Permission::create(['name' => 'update platforms']);
        Permission::create(['name' => 'delete platforms']);

        Permission::create(['name' => 'list posts']);
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'update posts']);
        Permission::create(['name' => 'delete posts']);

        Permission::create(['name' => 'list posttypes']);
        Permission::create(['name' => 'view posttypes']);
        Permission::create(['name' => 'create posttypes']);
        Permission::create(['name' => 'update posttypes']);
        Permission::create(['name' => 'delete posttypes']);

        Permission::create(['name' => 'list repositories']);
        Permission::create(['name' => 'view repositories']);
        Permission::create(['name' => 'create repositories']);
        Permission::create(['name' => 'update repositories']);
        Permission::create(['name' => 'delete repositories']);

        Permission::create(['name' => 'list repositorytags']);
        Permission::create(['name' => 'view repositorytags']);
        Permission::create(['name' => 'create repositorytags']);
        Permission::create(['name' => 'update repositorytags']);
        Permission::create(['name' => 'delete repositorytags']);

        Permission::create(['name' => 'list repositorytypes']);
        Permission::create(['name' => 'view repositorytypes']);
        Permission::create(['name' => 'create repositorytypes']);
        Permission::create(['name' => 'update repositorytypes']);
        Permission::create(['name' => 'delete repositorytypes']);

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

        Permission::create(['name' => 'list vendors']);
        Permission::create(['name' => 'view vendors']);
        Permission::create(['name' => 'create vendors']);
        Permission::create(['name' => 'update vendors']);
        Permission::create(['name' => 'delete vendors']);

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
