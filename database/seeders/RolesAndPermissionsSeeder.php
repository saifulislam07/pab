<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder {
    public function run(): void {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-gallery',
            'manage-team',
            'manage-sponsors',
            'manage-events',
            'manage-settings',
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $memberRole = Role::updateOrCreate(['name' => 'member']);
        $memberRole->syncPermissions(['view-dashboard']);

        // Assign Roles to Existing Users based on their 'role' column
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'admin') {
                $user->assignRole($adminRole);
            } else {
                $user->assignRole($memberRole);
            }
        }
    }
}
