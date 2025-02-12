<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\DepartmentService;
use Throwable;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $departments = $this->departmentService->getAllDepartments();

            return new ApiSuccessResponse(
                data: $departments,
                message: ['Departments retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve departments.']
            );
        }
    }

    public function store(StoreDepartmentRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $department = $this->departmentService->createDepartment($request->validated());

            return new ApiSuccessResponse(
                data: $department,
                message: ['Department created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create department.']
            );
        }
    }

    public function update(UpdateDepartmentRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $department = $this->departmentService->updateDepartment($id, $request->validated());

            return new ApiSuccessResponse(
                data: $department,
                message: ['Department updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update department.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->departmentService->deleteDepartment($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Department deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete department.']
            );
        }
    }
}
