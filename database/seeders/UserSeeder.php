<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin1@gmail.com'],
            [
                'name' => 'Super Admin 1',
                'email' => 'superadmin1@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('SuperAdmin1234'),
                'role' => 'admin',
            ]
        );

        // Create Regular User for Testing
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
