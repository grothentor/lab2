<?php

use Database\Seeds\CustomSeeder;

class UsersTableSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('098765'),
            'role' => 'superadmin',
            'api_token' => str_random(60),
        ]);

    }
}
