<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating users and assigning roles
        $candidate = User::create([
            'name' => 'John Candidate',
            'email' => 'candidate@example.com',
            'password' => Hash::make('password'),
        ]);
        $candidate->assignRole('Candidate'); // Assigns the 'Candidate' role

        $employee = User::create([
            'name' => 'Jane Employee',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
        ]);
        $employee->assignRole('Employee'); // Assigns the 'Employee' role

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Administrator'); // Assigns the 'Administrator' role
    }
}
