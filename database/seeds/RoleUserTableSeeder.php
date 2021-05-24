<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('role_user')->truncate();

        $relations[] = [
            'role_id' => 1,
            'user_id' => 1,
        ];

        DB::table('role_user')->insert($relations);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
