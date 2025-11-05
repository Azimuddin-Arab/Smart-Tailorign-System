<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin2025@gmail.com'], // unique identifier
            [
                'name' => 'Admin',
                'email' => 'admin2025@gmail.com',
                'password' => Hash::make('superAdmin123'), // hashed password
            ]
        );

        // Optional: create additional test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'Admin@example.com',
        ]);
    }
}
