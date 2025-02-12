<?php

namespace App\Http\Controllers;

use App\Services\WorkHoursService;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Throwable;

class WorkHoursController extends Controller
{
    protected WorkHoursService $workHoursService;

    public function __construct(WorkHoursService $workHoursService)
    {
        $this->workHoursService = $workHoursService;
    }

    public function startWork(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $userId = Auth::id();
            $workHour = $this->workHoursService->startWork($userId);

            return new ApiSuccessResponse(
                data: $workHour,
                message: ['Workday started successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to start workday.']);
        }
    }

    public function endWork(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $userId = Auth::id();
            $workHour = $this->workHoursService->endWork($userId);

            return new ApiSuccessResponse(
                data: $workHour,
                message: ['Workday ended successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to end workday.']);
        }
    }

    public function history(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $filters = $request->only(['user_id', 'start_date', 'end_date']);
            $workHours = $this->workHoursService->getWorkHoursHistory($filters);

            return new ApiSuccessResponse(
                data: $workHours,
                message: ['Work hours retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve work hours.']);
        }
    }
}
