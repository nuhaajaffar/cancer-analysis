<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);

        User::create([
            'name' => 'Radiographer User',
            'email' => 'radiographer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'radiographer',
        ]);

        User::create([
            'name' => 'Radiologist User',
            'email' => 'radiologist@example.com',
            'password' => Hash::make('password123'),
            'role' => 'radiologist',
        ]);

        User::create([
            'name' => 'Patient One',
            'email' => 'patient1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        User::create([
            'name' => 'Patient Two',
            'email' => 'patient2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);
    }
}
