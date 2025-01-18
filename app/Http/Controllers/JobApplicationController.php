<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationStageOrDecisionRequest;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\UpdateReviewerRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;
use App\Services\JobApplicationService;
use Throwable;
use Illuminate\Support\Facades\Storage;


class JobApplicationController extends Controller
{
    protected $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    public function store(StoreJobApplicationRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $user = auth()->user();

            if (!$user instanceof User) {
                throw new \Exception('Authenticated user is invalid.');
            }

            $validatedData = $request->validated();

            $this->jobApplicationService->checkIfAlreadyApplied($user->id, $validatedData['job_offer_id']);
            $jobApplication = $this->jobApplicationService->createApplication($user, $validatedData);
            $this->jobApplicationService->saveAnswers($jobApplication, $validatedData['answers']);

            return new ApiSuccessResponse(
                data: $jobApplication->load('answers'),
                message: ['Job application created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to create job application.']);
        }
    }


    public function showMyApplications(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $applications = $this->jobApplicationService->getApplicationsByUser(auth()->id());

            return new ApiSuccessResponse(
                data: $applications,
                message: ['Applications retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve applications.']);
        }
    }

    public function addComment(AddCommentRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validated = $request->validated();
            $comment = $this->jobApplicationService->addComment($id, auth()->id(), $validated['content']);

            return new ApiSuccessResponse(
                data: $comment,
                message: ['Comment added successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to add comment.']);
        }
    }

    public function getComments(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $comments = $this->jobApplicationService->getComments($id);

            return new ApiSuccessResponse(
                data: $comments,
                message: ['Comments retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve comments.']
            );
        }
    }


    public function updateStageOrDecision(UpdateJobApplicationStageOrDecisionRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validated = $request->validated();
            $jobApplication = $this->jobApplicationService->updateStageOrDecision($id, $validated);

            return new ApiSuccessResponse(
                data: $jobApplication,
                message: ['Job application updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to update job application.']);
        }
    }

    public function updateReviewer(UpdateReviewerRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $reviewerId = $request->validated()['reviewer_id'];

            $jobApplication = $this->jobApplicationService->updateReviewer($id, $reviewerId);

            return new ApiSuccessResponse(
                data: $jobApplication,
                message: ['Reviewer updated successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update reviewer.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $application = $this->jobApplicationService->getApplicationById($id);

            return new ApiSuccessResponse(
                data: $application,
                message: ['Job application retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse($e, ['Failed to retrieve job application.']);
        }
    }

    public function exportJobApplications(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $jobApplications = $this->jobApplicationService->getAllJobApplicationsForExport();

            return new ApiSuccessResponse(
                data: $jobApplications,
                message: ['Job applications exported successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to export job applications.']
            );
        }
    }

}
