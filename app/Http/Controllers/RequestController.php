<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestStatusRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\RequestService;
use Throwable;

class RequestController extends Controller
{
    protected RequestService $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    public function index(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requests = $this->requestService->getUserRequests();

            return new ApiSuccessResponse(
                data: $requests,
                message: ['Requests retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve requests.']);
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $request = $this->requestService->getUserRequestById($id);

            return new ApiSuccessResponse(
                data: $request,
                message: ['Request details retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve request details.']);
        }
    }

    public function store(StoreRequestRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $requestEntry = $this->requestService->createRequest($request->validated());

            return new ApiSuccessResponse(
                data: $requestEntry,
                message: ['Request submitted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to submit request.']);
        }
    }

    public function updateStatus(UpdateRequestStatusRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $updatedRequest = $this->requestService->updateRequestStatus($id, $request->validated()['status']);

            return new ApiSuccessResponse(
                data: $updatedRequest,
                message: ['Request status updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to update request status.']);
        }
    }
    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->requestService->deleteRequest($id);

            return new ApiSuccessResponse(
                message: ['Request deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to delete request.']);
        }
    }
}
