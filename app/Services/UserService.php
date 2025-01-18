<?php

namespace App\Services;

use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Traits\HandlesRelationships;


class UserService
{
    use HandlesRelationships;
    public function getAllUsers(array $queryParams = [])
    {
        $query = User::query();

        $this->applyRelationships($query, $queryParams);

        return $query->paginate($queryParams['per_page'] ?? 10);
    }

    public function getUserById(int $id, array $queryParams = []): Model
    {
        $query = User::query();

        $this->applyRelationships($query, $queryParams);

        return $query->findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'firstname' => $data['firstname'],
                'surname' => $data['surname'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => now(),
            ]);

            $user->assignRole($data['role']);

            $user->userDetails()->create([
                'sex' => $data['sex'],
                'department' => $data['department'] ?? null,
                'position' => $data['position'] ?? null,
                'address' => $data['address'],
                'address2' => $data['address2'] ?? null,
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'phone_no' => $data['phone_no'],
            ]);

            return $user;
        });
    }

    public function updateUser(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function getUserPreferences(int $userId): array
    {
        $user = User::with('preferences')->findOrFail($userId);

        return $user->preferences->map(function ($preference) {
            return [
                'preference_id' => $preference->id,
                'name' => $preference->name,
                'description' => $preference->description,
                'value' => $preference->pivot->value,
            ];
        })->toArray();
    }

    public function updateUserPreferences(int $userId, array $preferences): void
    {
        $user = User::findOrFail($userId);

        $preferenceData = collect($preferences)->mapWithKeys(function ($preference) {
            return [$preference['preference_id'] => ['value' => $preference['value']]];
        });

        $user->preferences()->syncWithoutDetaching($preferenceData);
    }

    public function changeUserRole(int $id, string $role): void
    {
        $user = User::findOrFail($id);
        $user->syncRoles([$role]);
    }
}
