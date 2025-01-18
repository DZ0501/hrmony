<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachTagsRequest;
use App\Http\Requests\DetachTagsRequest;
use App\Http\Requests\StoreRequirementRequest;
use App\Http\Requests\UpdateRequirementRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\RequirementService;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    protected RequirementService $requirementService;

    public function __construct(RequirementService $requirementService)
    {
        $this->requirementService = $requirementService;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirements = $this->requirementService->getAllRequirements($request->query());

            return new ApiSuccessResponse(
                data: $requirements,
                message: ['Requirements retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve requirements.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirement = $this->requirementService->getRequirementById($id);

            return new ApiSuccessResponse(
                data: $requirement,
                message: ['Requirement retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve requirement.']
            );
        }
    }

    public function store(StoreRequirementRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirement = $this->requirementService->createRequirement($request->validated());

            return new ApiSuccessResponse(
                data: $requirement,
                message: ['Requirement created successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create requirement.']
            );
        }
    }

    public function update(UpdateRequirementRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirement = $this->requirementService->updateRequirement($id, $request->validated());

            return new ApiSuccessResponse(
                data: $requirement,
                message: ['Requirement updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update requirement.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->requirementService->deleteRequirement($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Requirement deleted successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete requirement.']
            );
        }
    }

    public function attachTags(AttachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirement = $this->requirementService->attachTags($id, $request->validated()['tag_ids']);

            return new ApiSuccessResponse(
                data: $requirement,
                message: ['Tags attached successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to attach tags.']
            );
        }
    }

    public function detachTags(DetachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirement = $this->requirementService->detachTags($id, $request->validated()['tag_ids']);

            return new ApiSuccessResponse(
                data: $requirement,
                message: ['Tags detached successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to detach tags.']
            );
        }
    }
}
