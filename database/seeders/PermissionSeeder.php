<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view employee',
            'create employee',
            'edit employee',
            'delete employee',
            'view users',
            'manage roles',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());
    }
}
