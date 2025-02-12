<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCreationService
{
    public function createUser(array $data, string $role): User
    {
        return DB::transaction(function () use ($data, $role) {
            $user = User::create([
                'email' => $data['email'],
                'firstname' => $data['firstname'],
                'surname' => $data['surname'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => $data['email_verified_at'] ?? null,
            ]);

            $user->assignRole($role);

            $user->userDetails()->create([
                'sex' => $data['sex'],
                'department_id' => $data['department_id'] ?? null,
                'position_id' => $data['position_id'] ?? null,
                'address' => $data['address'],
                'address2' => $data['address2'] ?? null,
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'phone_no' => $data['phone_no'],
            ]);

            return $user;
        });
    }
}
