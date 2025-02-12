<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\EquipmentService;
use Illuminate\Http\Request;
use Throwable;

class EquipmentController extends Controller
{
    protected EquipmentService $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $equipment = $this->service->getAllEquipment($request->query());

            return new ApiSuccessResponse(data: $equipment, message: ['Equipment retrieved successfully.']);
        } catch (Throwable $e) {
            return new ApiErrorResponse(exception: $e, message: ['Failed to retrieve equipment.']);
        }
    }

    public function store(StoreEquipmentRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $equipment = $this->service->createEquipment($request->validated());

            return new ApiSuccessResponse(data: $equipment, message: ['Equipment created successfully.']);
        } catch (Throwable $e) {
            return new ApiErrorResponse(exception: $e, message: ['Failed to create equipment.']);
        }
    }

    public function update(UpdateEquipmentRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $equipment = $this->service->updateEquipment($id, $request->validated());

            return new ApiSuccessResponse(data: $equipment, message: ['Equipment updated successfully.']);
        } catch (Throwable $e) {
            return new ApiErrorResponse(exception: $e, message: ['Failed to update equipment.']);
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->service->deleteEquipment($id);

            return new ApiSuccessResponse(message: ['Equipment deleted successfully.']);
        } catch (Throwable $e) {
            return new ApiErrorResponse(exception: $e, message: ['Failed to delete equipment.']);
        }
    }
}
