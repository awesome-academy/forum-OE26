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
            [
                'name' => config('permission.create_answer'),
                'description' => 'Create a answer',
            ],
            [
                'name' => config('permission.update_answer'),
                'description' => 'Update a answer',
            ],
            [
                'name' => config('permission.delete_answer'),
                'description' => 'Delete a answer',
            ],
        ]);
    }
}
