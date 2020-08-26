<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => config('roles.root_admin'),
                'description' => 'A root admin is a person who has supreme permissions to carry out all actions',
            ],
            [
                'name' => config('roles.admin'),
                'description' => 'An admin is a person who has permissions to perform most of actions except for user management actions',
            ],
            [
                'name' => config('roles.user'),
                'description' => 'A normal user can CRUD the posts, another user\'s profiles, ...',
            ],
            [
                'name' => config('roles.user_block_comment'),
                'description' => 'A normal user can not comment',
            ],
            [
                'name' => config('roles.user_block_answer'),
                'description' => 'A normal user can not answer',
            ],
            [
                'name' => config('roles.user_block_question'),
                'description' => 'A normal user can not question',
            ],
        ]);
    }
}
