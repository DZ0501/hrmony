<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateAttendanceBonusRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\AttendanceBonusService;
use Throwable;

class AttendanceBonusController extends Controller
{
    protected AttendanceBonusService $bonusService;

    public function __construct(AttendanceBonusService $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    public function calculateAndNotify(CalculateAttendanceBonusRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->bonusService->calculateAndNotify(
                $request->validated('month'),
                $request->validated('year'),
                $request->validated('required_work_hours')
            );

            return new ApiSuccessResponse(
                message: ['Attendance bonuses calculated and notifications sent successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to calculate attendance bonuses.']
            );
        }
    }
}
