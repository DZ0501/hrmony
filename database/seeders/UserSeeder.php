<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::create([
            'firstname' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('administrator');

        for ($i = 1; $i <= 2; $i++) {
            $hr = User::create([
                'firstname' => "HR$i",
                'surname' => 'Employee',
                'email' => "hr$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $hr->assignRole('hr_employee');
        }

        $deptHead = User::create([
            'firstname' => 'Department',
            'surname' => 'Head',
            'email' => 'depthead@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $deptHead->assignRole('chief_of_department');

        for ($i = 1; $i <= 3; $i++) {
            $candidate = User::create([
                'firstname' => "Candidate$i",
                'surname' => 'Applicant',
                'email' => "candidate$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $candidate->assignRole('candidate');
        }

        for ($i = 1; $i <= 3; $i++) {
            $employee = User::create([
                'firstname' => "Employee$i",
                'surname' => 'User',
                'email' => "employee$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $employee->assignRole('employee');
        }
    }
}
