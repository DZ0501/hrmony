<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\ResponsibilityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobOfferController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
Route::post('/auth/email/resend', [AuthController::class, 'resend'])->middleware('throttle:3,1');
Route::post('/auth/password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/auth/password/reset', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'signed'], function () {
    Route::get('/auth/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
        ->name('verification.verify')
        ->middleware('throttle:10,1');
});

Route::get('/password/reset/{token}', function ($token) {
    return response()->json(['token' => $token], 200);
})->name('password.reset');


Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/my-preferences', [UserController::class, 'getPreferences']);
    Route::post('/my-preferences', [UserController::class, 'updatePreferences']);

    Route::get('/job-offers', [JobOfferController::class, 'index']);
    Route::get('/job-offers/{id}', [JobOfferController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:candidate', 'throttle:api'])->group(function () {
    Route::post('/job-applications', [JobApplicationController::class, 'store']);
    Route::get('/my-job-applications', [JobApplicationController::class, 'showMyApplications']); // View own applications
});

Route::middleware(['auth:sanctum', 'role:hr_employee|administrator', 'throttle:api'])->group(function () {
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    Route::get('/responsibilities', [ResponsibilityController::class, 'index']);
    Route::get('/responsibilities/{id}', [ResponsibilityController::class, 'show']);
    Route::post('/responsibilities', [ResponsibilityController::class, 'store']);
    Route::put('/responsibilities/{id}', [ResponsibilityController::class, 'update']);
    Route::delete('/responsibilities/{id}', [ResponsibilityController::class, 'destroy']);

    Route::post('/responsibilities/{id}/tags', [ResponsibilityController::class, 'attachTags']);
    Route::delete('/responsibilities/{id}/tags', [ResponsibilityController::class, 'detachTags']);

    Route::get('/requirements', [RequirementController::class, 'index']);
    Route::get('/requirements/{id}', [RequirementController::class, 'show']);
    Route::post('/requirements', [RequirementController::class, 'store']);
    Route::put('/requirements/{id}', [RequirementController::class, 'update']);
    Route::delete('/requirements/{id}', [RequirementController::class, 'destroy']);

    Route::post('/requirements/{id}/tags', [RequirementController::class, 'attachTags']);
    Route::delete('/requirements/{id}/tags', [RequirementController::class, 'detachTags']);

    Route::get('/questions', [QuestionController::class, 'index']);
    Route::get('/questions/{id}', [QuestionController::class, 'show']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::put('/questions/{id}', [QuestionController::class, 'update']);
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);

    Route::post('/questions/{id}/tags', [QuestionController::class, 'attachTags']);
    Route::delete('/questions/{id}/tags', [QuestionController::class, 'detachTags']);

    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/positions/{id}', [PositionController::class, 'show']);
    Route::post('/positions', [PositionController::class, 'store']);
    Route::put('/positions/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);

    Route::post('/positions/{id}/responsibilities/sync', [PositionController::class, 'syncResponsibilities']);
    Route::post('/positions/{id}/requirements/sync', [PositionController::class, 'syncRequirements']);

    Route::post('/job-offers', [JobOfferController::class, 'store']);
    Route::put('/job-offers/{id}', [JobOfferController::class, 'update']);
    Route::delete('/job-offers/{id}', [JobOfferController::class, 'destroy']);

    Route::get('/job-applications/export', [JobApplicationController::class, 'exportJobApplications']);
});

Route::middleware(['auth:sanctum', 'role:hr_employee|department_head|administrator', 'throttle:api'])->group(function () {
    Route::get('/job-applications/{id}', [JobApplicationController::class, 'show']);
    Route::patch('/job-applications/{id}/stage-decision', [JobApplicationController::class, 'updateStageOrDecision']);
    Route::patch('/job-applications/{id}/reviewer', [JobApplicationController::class, 'updateReviewer']);
    Route::post('/job-applications/{id}/comments', [JobApplicationController::class, 'addComment']);
    Route::get('/job-applications/{id}/comments', [JobApplicationController::class, 'getComments']);
});

Route::middleware(['auth:sanctum', 'role:administrator', 'throttle:api'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings/{key}', [SettingController::class, 'update']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/users/{id}/role', [UserController::class, 'changeRole']);
});
