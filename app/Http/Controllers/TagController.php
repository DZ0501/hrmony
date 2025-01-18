<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\TagService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $tags = $this->tagService->getAllTags();

            return new ApiSuccessResponse(
                data: $tags,
                message: ['Tags retrieved successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve tags.']
            );
        }
    }

    public function show(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $tag = $this->tagService->getTagById($id);

            return new ApiSuccessResponse(
                data: $tag,
                message: ['Tag retrieved successfully.']
            );
        } catch (ModelNotFoundException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Tag not found.'],
                status: 404
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to retrieve tag.']
            );
        }
    }

    public function store(StoreTagRequest $request): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $tag = $this->tagService->createTag($request->validated());

            return new ApiSuccessResponse(
                data: $tag,
                message: ['Tag created successfully.']
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to create tag.']
            );
        }
    }

    public function update(UpdateTagRequest $request, int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $tag = $this->tagService->updateTag($id, $request->validated());

            return new ApiSuccessResponse(
                data: $tag,
                message: ['Tag updated successfully.']
            );
        } catch (ModelNotFoundException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Tag not found.'],
                status: 404
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to update tag.']
            );
        }
    }

    public function destroy(int $id): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->tagService->deleteTag($id);

            return new ApiSuccessResponse(
                data: null,
                message: ['Tag deleted successfully.']
            );
        } catch (ModelNotFoundException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Tag not found.'],
                status: 404
            );
        } catch (Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to delete tag.']
            );
        }
    }
}
