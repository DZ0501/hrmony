<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachTagsRequest;
use App\Http\Requests\DetachTagsRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $questions = $this->questionService->getAllQuestions($request->query());

            return new ApiSuccessResponse(
                data: $questions,
                message: ['Questions retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve questions.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $question = $this->questionService->getQuestionById($id);

            return new ApiSuccessResponse(
                data: $question,
                message: ['Question retrieved successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve question.']
            );
        }
    }

    public function store(StoreQuestionRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validatedData = $request->validated();

            $question = $this->questionService->createQuestion($validatedData);

            return new ApiSuccessResponse(
                data: $question,
                message: ['Question created successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create question.']
            );
        }
    }

    public function update(UpdateQuestionRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validatedData = $request->validated();

            $question = $this->questionService->updateQuestion($id, $validatedData);

            return new ApiSuccessResponse(
                data: $question,
                message: ['Question updated successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update question.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->questionService->deleteQuestion($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Question deleted successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete question.']
            );
        }
    }

    public function attachTags(AttachTagsRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $validatedData = $request->validated();

            $question = $this->questionService->attachTags($id, $validatedData['tag_ids']);

            return new ApiSuccessResponse(
                data: $question,
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
            $validatedData = $request->validated();

            $question = $this->questionService->detachTags($id, $validatedData['tag_ids']);

            return new ApiSuccessResponse(
                data: $question,
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
