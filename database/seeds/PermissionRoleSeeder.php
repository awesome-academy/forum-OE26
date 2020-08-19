<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        // Root admin have all permissions
        $permissionIds = Permission::pluck('id')->toArray();
        Role::where('name', config('roles.root_admin'))
            ->first()
            ->permissions()
            ->sync($permissionIds);

        $permissionIds = Permission::whereIn('name', [
            // Permissions of admin
            config('permission.create_question'),
            config('permission.update_question'),
            config('permission.delete_question'),
            config('permission.create_answer'),
            config('permission.update_answer'),
            config('permission.delete_answer'),
        ])
            ->pluck('id')
            ->toArray();
        Role::where('name', config('roles.admin'))
            ->first()
            ->permissions()
            ->sync($permissionIds);

        $permissionIds = Permission::whereIn('name', [
            // Permissions of user
            config('permission.create_question'),
            config('permission.update_question'),
            config('permission.create_answer'),
            config('permission.update_answer'),
        ])
            ->pluck('id')
            ->toArray();
        Role::where('name', config('roles.user'))
            ->first()
            ->permissions()
            ->sync($permissionIds);
    }
}
