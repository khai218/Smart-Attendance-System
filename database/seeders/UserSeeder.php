<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Optional: Truncate the users table to clear existing data
        DB::table('users')->truncate();
        
        // Create admin users using firstOrCreate
        User::firstOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'name' => 'Admin_1',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin_2',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin3@example.com'],
            [
                'name' => 'Admin_3',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin4@example.com'],
            [
                'name' => 'Admin_4',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin5@example.com'],
            [
                'name' => 'Admin_5',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
