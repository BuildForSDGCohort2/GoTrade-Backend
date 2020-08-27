<?php

use Illuminate\Database\Seeder;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> ad1c7263a825d09c38ff714e9bfc326be32b9467

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
<<<<<<< HEAD
=======
        
        DB::table('users')->insert([
            [
                'display_name' => 'Administrator',
                'first_name' => 'Administrator',
                'mobile_number' => '08030000000',
                'email' => 'admin@gotrade.com',                
                'gender' => 'male',
                'password' => Hash::make('Admin$123'),
                'is_active' => 1,
                'role' => 'admin',
            ],
        ]);
>>>>>>> ad1c7263a825d09c38ff714e9bfc326be32b9467
    }
}
