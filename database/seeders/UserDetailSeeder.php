<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $managerId = null;

            if ($user->hasRole('employee')) {
                $managerId = User::role('chief_of_department')
                    ->orWhere('role', 'hr_employee')
                    ->inRandomOrder()
                    ->first()->id;
            }

            UserDetail::create([
                'user_id' => $user->id,
                'manager_id' => $managerId,
                'sex' => ['male', 'female'][rand(0, 1)],
                'department_id' => rand(1, 5),
                'position_id' => rand(1, 5),
                'address' => '123 Main St',
                'address2' => null,
                'city' => 'Sample City',
                'postcode' => '12345',
                'phone_no' => '123-456-7890',
            ]);
        }
    }
}
