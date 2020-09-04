<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            [
                'display_name' => 'Administrator',
                'first_name' => 'Administrator',
                'mobile_number' => '08030000000',
                'email' => 'admin@gotrade.com.ng',
                'gender' => 'male',
                'password' => Hash::make('Admin@123'),
                'is_active' => 1,
                'role' => 'admin',
            ],
        ]);
    }
}