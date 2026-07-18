<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = config('auth.defaults.guard', 'web');

        $permissions = [
            'dashboard.view',
            'sales.view',
            'sales.create',
            'sales.update',
            'sales.delete',
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
            'items.view',
            'items.create',
            'items.update',
            'items.delete',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, $guard);
        }

        $admin = Role::findOrCreate('admin', $guard);
        $admin->syncPermissions(
            Permission::query()->where('guard_name', $guard)->get()
        );

        $staff = Role::findOrCreate('staff', $guard);
        $staff->syncPermissions([
            'dashboard.view',
            'sales.view',
            'sales.create',
            'sales.update',
            'payments.view',
            'payments.create',
            'payments.update',
            'items.view',
        ]);
    }
}
