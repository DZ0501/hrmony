<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentTypeRequest;
use App\Http\Requests\UpdateEquipmentTypeRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\EquipmentTypeService;
use Throwable;

class EquipmentTypeController extends Controller
{
    protected EquipmentTypeService $typeService;

    public function __construct(EquipmentTypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function index(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $types = $this->typeService->getAll();

            return new ApiSuccessResponse(
                data: $types,
                message: ['Equipment types retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve equipment types.']
            );
        }
    }

    public function store(StoreEquipmentTypeRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $type = $this->typeService->create($request->validated());

            return new ApiSuccessResponse(
                data: $type,
                message: ['Equipment type created successfully.'],
                status: 201
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create equipment type.']
            );
        }
    }
    public function update(UpdateEquipmentTypeRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $type = $this->typeService->update($id, $request->validated());

            return new ApiSuccessResponse(
                data: $type,
                message: ['Equipment type updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update equipment type.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->typeService->delete($id);

            return new ApiSuccessResponse(
                message: ['Equipment type deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete equipment type.']
            );
        }
    }
}
