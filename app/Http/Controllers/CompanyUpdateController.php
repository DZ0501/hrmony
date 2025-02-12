<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachTagsRequest;
use App\Http\Requests\StoreCompanyUpdateRequest;
use App\Http\Requests\UpdateCompanyUpdateRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\CompanyUpdateService;
use Illuminate\Http\Request;
use Throwable;

class CompanyUpdateController extends Controller
{
    protected CompanyUpdateService $service;

    public function __construct(CompanyUpdateService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $updates = $this->service->getAllUpdates($request->query());

            return new ApiSuccessResponse(
                data: $updates,
                message: ['Updates retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve updates.']
            );
        }
    }


    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $update = $this->service->getUpdateById($id);

            return new ApiSuccessResponse(
                data: $update,
                message: ['Update retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve update.']
            );
        }
    }

    public function store(StoreCompanyUpdateRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $update = $this->service->createUpdate($request->validated());

            return new ApiSuccessResponse(
                data: $update,
                message: ['Update created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create update.']
            );
        }
    }

    public function update(UpdateCompanyUpdateRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $update = $this->service->updateUpdate($id, $request->validated());

            return new ApiSuccessResponse(
                data: $update,
                message: ['Update updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update update.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->service->deleteUpdate($id);

            return new ApiSuccessResponse(
                message: ['Update deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete update.']
            );
        }
    }

    public function attachTags(AttachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validatedData = $request->validated();

            $update = $this->service->attachTags($id, $validatedData['tag_ids']);

            return new ApiSuccessResponse(
                data: $update,
                message: ['Tags attached successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to attach tags.']
            );
        }
    }

    public function detachTags(AttachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validatedData = $request->validated();

            $update = $this->service->detachTags($id, $validatedData['tag_ids']);

            return new ApiSuccessResponse(
                data: $update,
                message: ['Tags detached successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to detach tags.']
            );
        }
    }


    public function publish(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $update = $this->service->publishUpdate($id);

            return new ApiSuccessResponse(
                data: $update,
                message: ['Update published successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to publish update.']
            );
        }
    }
}
