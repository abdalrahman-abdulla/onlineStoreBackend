<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'abdalrahman',
            'email' => 'a@a.com',
            'email_verified_at' => now(),
            'phone' => '07724018497',
            'user_type' => 0,
            'password' => Hash::make('12121212'),
        ]);
    }
}
