<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Requests\StoreUserPreferenceRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $users = $this->userService->getAllUsers($request->query());

            return new ApiSuccessResponse(
                data: $users,
                message: ['Users retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve users.']
            );
        }
    }


    public function show(Request $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $user = $this->userService->getUserById($id, $request->query());

            return new ApiSuccessResponse(
                data: $user,
                message: ['User retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve user.']
            );
        }
    }

    public function store(StoreUserRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $user = $this->userService->createUser($request->validated());

            return new ApiSuccessResponse(
                data: $user,
                message: ['User created successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create user.']
            );
        }
    }

    public function update(UpdateUserRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());

            return new ApiSuccessResponse(
                data: $user,
                message: ['User updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update user.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->userService->deleteUser($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['User deleted successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete user.']
            );
        }
    }

    public function updatePreferences(StoreUserPreferenceRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->userService->updateUserPreferences(auth()->id(), $request->validated()['preferences']);

            return new ApiSuccessResponse(
                data: null,
                message: ['Preferences updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update preferences.']
            );
        }
    }

    public function getPreferences(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $preferences = $this->userService->getUserPreferences(auth()->id());

            return new ApiSuccessResponse(
                data: $preferences,
                message: ['Preferences retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve preferences.']
            );
        }
    }

    public function changeRole(ChangeUserRoleRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->userService->changeUserRole($id, $request->validated()['role']);

            return new ApiSuccessResponse(
                data: null,
                message: ['User role updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update user role.']
            );
        }
    }
}
