<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Populate User details for existing Users (IDs 8-10)
        for ($i = 8; $i <= 10; $i++) {
            UserDetail::create([
                'user_id' => $i,
                'sex' => ['male', 'female'][rand(0,1)],
                'department' => ['Engineering', 'HR', 'Sales'][rand(0, 2)], // Random departments
                'position' => ['Developer', 'Manager', 'Analyst'][rand(0, 2)], // Random positions
                'address' => '123 Main St',
                'city' => 'Sample City',
                'postcode' => '12345',
                'phone_no' => '123-456-7890',
            ]);
        }
    }
}
