<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAndAssignEquipmentUsageRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\EquipmentUsageService;
use Illuminate\Http\Request;
use Throwable;

class EquipmentUsageController extends Controller
{
    protected EquipmentUsageService $usageService;

    public function __construct(EquipmentUsageService $usageService)
    {
        $this->usageService = $usageService;
    }

    public function index(int $equipmentId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $history = $this->usageService->getUsage($equipmentId);

            return new ApiSuccessResponse(
                data: $history,
                message: ['Equipment usage history retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve equipment usage history.']
            );
        }
    }

    public function assign(StoreAndAssignEquipmentUsageRequest $request, int $equipmentId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $usage = $this->usageService->assignEquipment(
                equipmentId: $equipmentId,
                userId: $request->validated()['user_id']
            );

            return new ApiSuccessResponse(
                data: $usage,
                message: ['Equipment assigned successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to assign equipment.']
            );
        }
    }

    public function return(Request $request, int $equipmentId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $usage = $this->usageService->returnEquipment($equipmentId);

            return new ApiSuccessResponse(
                data: $usage,
                message: ['Equipment returned successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to return equipment.']
            );
        }
    }
}
