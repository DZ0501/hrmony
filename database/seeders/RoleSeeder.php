<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Candidate']); // role_id 1
        Role::create(['name' => 'Recruit']);   // role_id 2
        Role::create(['name' => 'Employee']);  // role_id 3
        Role::create(['name' => 'Chief of Department']); // role_id 4
        Role::create(['name' => 'HR Employee']);         // role_id 5
        Role::create(['name' => 'Administrator']);       // role_id 6
    }
}
