<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesRelationships;


class UserService
{
    use HandlesRelationships;
    protected UserCreationService $userCreationService;

    public function __construct(UserCreationService $userCreationService)
    {
        $this->userCreationService = $userCreationService;
    }

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
        return $this->userCreationService->createUser($data, $data['role']);
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

    public function assignPosition(int $userId, ?int $positionId): UserDetail
    {
        $userDetails = UserDetail::where('user_id', $userId)->firstOrFail();
        $userDetails->position_id = $positionId;
        $userDetails->save();

        return $userDetails;
    }

    public function assignDepartment(int $userId, int $departmentId): UserDetail
    {
        $userDetail = UserDetail::where('user_id', $userId)->firstOrFail();
        $userDetail->department_id = $departmentId;
        $userDetail->save();

        return $userDetail;
    }
}
