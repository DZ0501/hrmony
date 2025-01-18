<?php

namespace App\Http\Controllers;

use App\Enums\SettingKey;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $settings = $this->settingService->getAllSettings();

            return new ApiSuccessResponse(
                data: $settings,
                message: ['Settings retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve settings.']
            );
        }
    }

    public function update(UpdateSettingRequest $request, $key): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            if (!SettingKey::tryFrom($key)) {
                return new ApiErrorResponse(
                    exception: null,
                    message: ['Invalid setting key.'],
                    status: 400
                );
            }

            $validated = $request->validated();

            $this->settingService->updateSetting(SettingKey::from($key), $validated['value']);

            return new ApiSuccessResponse(
                data: ['key' => $key, 'value' => $validated['value']],
                message: ['Setting updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update setting.']
            );
        }
    }
}
