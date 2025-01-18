<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Requests\SyncResponsibilitiesRequest;
use App\Http\Requests\SyncRequirementsRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\PositionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

class PositionController extends Controller
{
    protected PositionService $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $positions = $this->positionService->getAllPositions();

            return new ApiSuccessResponse(
                data: $positions,
                message: ['Positions retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve positions.']
            );
        }
    }

    public function show(Request $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $position = $this->positionService->getPositionById($id, $request->query());

            return new ApiSuccessResponse(
                data: $position,
                message: ['Position retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve position.']
            );
        }
    }


    public function store(StorePositionRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $position = $this->positionService->createPosition($request->validated());

            return new ApiSuccessResponse(
                data: $position,
                message: ['Position created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create position.']
            );
        }
    }

    public function update(UpdatePositionRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $position = $this->positionService->updatePosition($id, $request->validated());

            return new ApiSuccessResponse(
                data: $position,
                message: ['Position updated successfully.']
            );
        } catch (ModelNotFoundException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Position not found.'],
                status: 404
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update position.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->positionService->deletePosition($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Position deleted successfully.']
            );
        } catch (ModelNotFoundException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Position not found.'],
                status: 404
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete position.']
            );
        }
    }

    public function syncResponsibilities(SyncResponsibilitiesRequest $request, int $positionId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $responsibilityIds = $request->validated()['responsibility_ids'] ?? [];
            $position = $this->positionService->getPositionById($positionId);

            $this->positionService->syncResponsibilities($position, $responsibilityIds);

            return new ApiSuccessResponse(
                data: $position->load('responsibilities'),
                message: ['Responsibilities synced successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to sync responsibilities.']
            );
        }
    }

    public function syncRequirements(SyncRequirementsRequest $request, int $positionId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requirementIds = $request->validated()['requirement_ids'] ?? [];
            $position = $this->positionService->getPositionById($positionId);

            $this->positionService->syncRequirements($position, $requirementIds);

            return new ApiSuccessResponse(
                data: $position->load('requirements'),
                message: ['Requirements synced successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to sync requirements.']
            );
        }
    }
}
