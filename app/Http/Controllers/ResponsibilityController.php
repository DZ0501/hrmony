<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachTagsRequest;
use App\Http\Requests\DetachTagsRequest;
use App\Http\Requests\StoreResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\ResponsibilityService;
use Illuminate\Http\Request;
use Throwable;

class ResponsibilityController extends Controller
{
    protected ResponsibilityService $responsibilityService;

    public function __construct(ResponsibilityService $responsibilityService)
    {
        $this->responsibilityService = $responsibilityService;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibilities = $this->responsibilityService->getAllResponsibilities($request->query());

            return new ApiSuccessResponse(
                data: $responsibilities,
                message: ['Responsibilities retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve responsibilities.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibility = $this->responsibilityService->getResponsibilityById($id);

            return new ApiSuccessResponse(
                data: $responsibility,
                message: ['Responsibility retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve responsibility.']
            );
        }
    }

    public function store(StoreResponsibilityRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibility = $this->responsibilityService->createResponsibility($request->validated());

            return new ApiSuccessResponse(
                data: $responsibility,
                message: ['Responsibility created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create responsibility.']
            );
        }
    }

    public function update(UpdateResponsibilityRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibility = $this->responsibilityService->updateResponsibility($id, $request->validated());

            return new ApiSuccessResponse(
                data: $responsibility,
                message: ['Responsibility updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update responsibility.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->responsibilityService->deleteResponsibility($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Responsibility deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete responsibility.']
            );
        }
    }

    public function attachTags(AttachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibility = $this->responsibilityService->attachTags($id, $request->validated()['tag_ids']);

            return new ApiSuccessResponse(
                data: $responsibility,
                message: ['Tags attached successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to attach tags.']
            );
        }
    }

    public function detachTags(DetachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibility = $this->responsibilityService->detachTags($id, $request->validated()['tag_ids']);

            return new ApiSuccessResponse(
                data: $responsibility,
                message: ['Tags detached successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to detach tags.']
            );
        }
    }
}
