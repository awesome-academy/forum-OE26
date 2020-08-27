<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
            config('permission.create_comment'),
            config('permission.update_comment'),
            config('permission.delete_comment'),
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
            config('permission.delete_question'),
            config('permission.create_answer'),
            config('permission.update_answer'),
            config('permission.delete_answer'),
            config('permission.create_comment'),
            config('permission.update_comment'),
            config('permission.delete_comment'),
        ])
            ->pluck('id')
            ->toArray();
        Role::where('name', config('roles.user'))
            ->first()
            ->permissions()
            ->sync($permissionIds);

        $permissionIds = Permission::whereIn('name', [
            // Permissions of user
            config('permission.create_question'),
            config('permission.update_question'),
            config('permission.delete_question'),
            config('permission.create_answer'),
            config('permission.update_answer'),
            config('permission.delete_comment'),
        ])
            ->pluck('id')
            ->toArray();
        Role::where('name', config('roles.user_block_comment'))
            ->first()
            ->permissions()
            ->sync($permissionIds);

        $permissionIds = Permission::whereIn('name', [
            // Permissions of user
            config('permission.create_question'),
            config('permission.update_question'),
            config('permission.delete_question'),
        ])
            ->pluck('id')
            ->toArray();
        Role::where('name', config('roles.user_block_answer'))
            ->first()
            ->permissions()
            ->sync($permissionIds);

        $rootRoleId = Role::where('name', 'LIKE', config('roles.root_admin'))
            ->first()
            ->id;

        factory(User::class)->create([
            'email' => 'root@root.com',
            'role_id' => $rootRoleId,
        ]);
    }
}
