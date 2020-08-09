<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => config('permission.view_any_questions'),
                'description' => 'View any questions',
            ],
            [
                'name' => config('permission.view_question'),
                'description' => 'View a question',
            ],
            [
                'name' => config('permission.create_question'),
                'description' => 'Create a question',
            ],
            [
                'name' => config('permission.update_question'),
                'description' => 'Update a question',
            ],
            [
                'name' => config('permission.delete_question'),
                'description' => 'Delete a question',
            ],
        ]);
    }
}
