<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\JobOfferService;
use Throwable;

class JobOfferController extends Controller
{
    protected JobOfferService $jobOfferService;

    public function __construct(JobOfferService $jobOfferService)
    {
        $this->jobOfferService = $jobOfferService;
    }

    public function store(StoreJobOfferRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $validatedData = $request->validated();
            $validatedData['created_by'] = auth()->id();

            $jobOffer = $this->jobOfferService->createJobOffer($validatedData);

            return new ApiSuccessResponse(
                data: $jobOffer,
                message: ['Job offer created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to create job offer.']);
        }
    }

    public function update(UpdateJobOfferRequest $request, $id): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $validatedData = $request->validated();

            $jobOffer = $this->jobOfferService->updateJobOffer($id, $validatedData);

            return new ApiSuccessResponse(
                data: $jobOffer,
                message: ['Job offer updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to update job offer.']);
        }
    }


    public function destroy($id): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->jobOfferService->deleteJobOffer($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Job offer deleted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to delete job offer.']);
        }
    }

    public function show($id): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $jobOffer = $this->jobOfferService->getJobOffer($id);

            return new ApiSuccessResponse(
                data: $jobOffer,
                message: ['Job offer details retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve job offer details.']);
        }
    }

    public function index(): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $jobOffers = $this->jobOfferService->getAllJobOffers();

            return new ApiSuccessResponse(
                data: $jobOffers,
                message: ['Job offers retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve job offers.']);
        }
    }
}
