<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin2025@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin2025@gmail.com',
                'password' => Hash::make('superAdmin123'), 
                'role' => 'admin',
            ]
        );
    }
}
