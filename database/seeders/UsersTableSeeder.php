<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('users')->truncate();

        $user = [
            'name'                      => 'Mojtaba Pakzad',
            'username'                  => 'mj',
            'email'                     => 'pakzad@npco.net',
            'email_verified_at'         => now(),
            'mobile'                    => '09123456789',
            'mobile_verified_at'        => now(),
            'two_factor_verified_at'    => now(),
            'password'                  => bcrypt('mjpakzad@123'),
            'created_at'                => now(),
            'updated_at'                => now(),
        ];

        DB::table('users')->insert($user);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
