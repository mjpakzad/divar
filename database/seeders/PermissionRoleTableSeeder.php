<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_role')->truncate();

        $permissions = \App\Models\Permission::all()->toArray();
        $relations = [];

        foreach ($permissions as $permission)
        {
            $relations[] = [
                'role_id' => 1,
                'permission_id' => $permission['id']
            ];
        }

        DB::table('permission_role')->insert($relations);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
