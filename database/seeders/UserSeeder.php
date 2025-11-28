<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure to import the User model

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin.jnec@rub.edu.bt',
            'password' => Hash::make('password'), // The password is "password"
            'is_admin' => 1, // This is the important part
        ]);

        // Create a Regular User
        User::create([
            'name' => 'Sonam Lhamo',
            'email' => '05230134.jnec@rub.edu.bt',
            'password' => Hash::make('password'), // The password is "password"
            'is_admin' => 0, // This is a regular user
        ]);
    }
}