<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guardName = 'web';

        // Define all permissions
        $permissions = [
            'employee.view',
            'employee.create',
            'employee.edit',
            'employee.delete',
        ];

        // Create or update permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guardName
            ]);
        }

        // Create Admin role and sync all permissions
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => $guardName
        ]);
        $adminRole->syncPermissions($permissions);

        // Create User role with limited permissions
        $userRole = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => $guardName
        ]);
        $userRole->syncPermissions(['employee.view']);
    }
}
