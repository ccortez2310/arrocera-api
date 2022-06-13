<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return !str_starts_with($permission->value, 'admin:') &&
                !str_starts_with($permission->value, 'role:') &&
                !str_starts_with($permission->value, 'general-setting:') &&
                !str_starts_with($permission->value, 'commerce-setting:');
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
