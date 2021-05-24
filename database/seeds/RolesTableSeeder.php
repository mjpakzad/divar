<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
        $roles = [
            [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'مدیر سیستم',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'registered',
                'display_name' => 'کاربر',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('roles')->insert($roles);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
