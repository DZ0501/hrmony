<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BulkCreateEvaluationRequest;
use App\Http\Requests\AnswerEvaluationRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;
use App\Services\EvaluationService;
use Throwable;

class EvaluationController extends Controller
{
    protected EvaluationService $evaluationService;

    public function __construct(EvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $user = auth()->user();
            $this->evaluationService->ensureUserHasDetails($user);

            $isManager = $this->evaluationService->isManager($user->id);
            $filters = $request->query();

            $evaluations = $this->evaluationService->getEvaluationsForUser($user->id, $isManager, $filters);

            return new ApiSuccessResponse(
                data: $evaluations,
                message: ['Evaluations retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve evaluations.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $user = auth()->user();
            $this->evaluationService->ensureUserHasDetails($user);

            $isManager = $this->evaluationService->isManager($user->id);
            $evaluation = $this->evaluationService->getEvaluationDetails($id, $user->id, $isManager);

            return new ApiSuccessResponse(
                data: $evaluation,
                message: ['Evaluation details retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve evaluation details.']
            );
        }
    }

    public function bulkCreateEvaluations(BulkCreateEvaluationRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validated = $request->validated();

            $evaluations = $this->evaluationService->bulkCreateEvaluations($validated['quarter'], $validated['year']);

            return new ApiSuccessResponse(
                data: $evaluations,
                message: ['Evaluations created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create evaluations.']
            );
        }
    }

    public function answerEvaluation(AnswerEvaluationRequest $request, int $evaluationId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $answers = $this->evaluationService->answerEvaluation($evaluationId, $request->validated());

            return new ApiSuccessResponse(
                data: $answers,
                message: ['Evaluation answers submitted successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to submit evaluation answers.']
            );
        }
    }

    public function compareEvaluations(int $userId): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $comparisonData = $this->evaluationService->compareEvaluations($userId);

            return new ApiSuccessResponse(
                data: $comparisonData,
                message: ['Evaluations compared successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to compare evaluations.']
            );
        }
    }
}
