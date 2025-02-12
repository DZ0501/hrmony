<?php

use App\Http\Controllers\AttendanceBonusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyUpdateController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\EquipmentUsageController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\ResponsibilityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkHoursController;
use Illuminate\Support\Facades\Route;

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

    Route::controller(UserController::class)->group(function () {
        Route::get('/my-preferences', 'getPreferences');
        Route::post('/my-preferences', 'updatePreferences');
    });

    Route::controller(JobOfferController::class)->group(function () {
        Route::get('/job-offers', 'index');
        Route::get('/job-offers/{id}', 'show');
    });
});

Route::middleware(['auth:sanctum', 'role:candidate', 'throttle:api'])->group(function () {
    Route::controller(JobApplicationController::class)->group(function () {
        Route::post('/job-applications', 'store');
        Route::get('/my-job-applications', 'showMyApplications');
    });
});

Route::middleware(['auth:sanctum', 'role:hr_employee|department_head|administrator', 'throttle:api'])->group(function () {
    Route::controller(JobApplicationController::class)->group(function () {
        Route::get('/job-applications/{id}', 'show');
        Route::patch('/job-applications/{id}/stage-decision', 'updateStageOrDecision');
        Route::patch('/job-applications/{id}/reviewer', 'updateReviewer');
        Route::post('/job-applications/{id}/comments', 'addComment');
        Route::get('/job-applications/{id}/comments', 'getComments');
    });
});

Route::middleware(['auth:sanctum', 'role:hr_employee|administrator', 'throttle:api'])->group(function () {
    Route::controller(TagController::class)->group(function () {
        Route::get('/tags', 'index');
        Route::get('/tags/{id}', 'show');
        Route::post('/tags', 'store');
        Route::put('/tags/{id}', 'update');
        Route::delete('/tags/{id}', 'destroy');
    });

    Route::controller(ResponsibilityController::class)->group(function () {
        Route::get('/responsibilities', 'index');
        Route::get('/responsibilities/{id}', 'show');
        Route::post('/responsibilities', 'store');
        Route::put('/responsibilities/{id}', 'update');
        Route::delete('/responsibilities/{id}', 'destroy');
        Route::post('/responsibilities/{id}/tags', 'attachTags');
        Route::delete('/responsibilities/{id}/tags', 'detachTags');
    });

    Route::controller(RequirementController::class)->group(function () {
        Route::get('/requirements', 'index');
        Route::get('/requirements/{id}', 'show');
        Route::post('/requirements', 'store');
        Route::put('/requirements/{id}', 'update');
        Route::delete('/requirements/{id}', 'destroy');
        Route::post('/requirements/{id}/tags', 'attachTags');
        Route::delete('/requirements/{id}/tags', 'detachTags');
    });

    Route::controller(QuestionController::class)->group(function () {
        Route::get('/questions', 'index');
        Route::get('/questions/{id}', 'show');
        Route::post('/questions', 'store');
        Route::put('/questions/{id}', 'update');
        Route::delete('/questions/{id}', 'destroy');
        Route::post('/questions/{id}/tags', 'attachTags');
        Route::delete('/questions/{id}/tags', 'detachTags');
    });

    Route::controller(PositionController::class)->group(function () {
        Route::get('/positions', 'index');
        Route::get('/positions/{id}', 'show');
        Route::post('/positions', 'store');
        Route::put('/positions/{id}', 'update');
        Route::delete('/positions/{id}', 'destroy');
        Route::post('/positions/{id}/responsibilities/sync', 'syncResponsibilities');
        Route::post('/positions/{id}/requirements/sync', 'syncRequirements');
    });

    Route::controller(JobOfferController::class)->group(function () {
        Route::post('/job-offers', 'store');
        Route::put('/job-offers/{id}', 'update');
        Route::delete('/job-offers/{id}', 'destroy');
        Route::patch('/job-offers/{id}/publish', 'publish');
    });

    Route::controller(JobApplicationController::class)->group(function () {
        Route::get('/job-applications/export', 'exportJobApplications');
    });

    Route::controller(UserController::class)->group(function () {
        Route::patch('/users/{id}/assign-position', 'assignPosition');
        Route::patch('/users/{id}/assign-department', 'assignDepartment');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index');
        Route::post('/departments', 'store');
        Route::put('/departments/{id}', 'update');
        Route::delete('/departments/{id}', 'destroy');
    });

    Route::controller(AttendanceBonusController::class)->group(function () {
        Route::post('/attendance-bonuses/calculate', 'calculateAndNotify');
    });

    Route::controller(CompanyUpdateController::class)->group(function () {
        Route::get('/company-updates', 'index');
        Route::get('/company-updates/{id}', 'show');
        Route::post('/company-updates', 'store');
        Route::put('/company-updates/{id}', 'update');
        Route::post('/company-updates/{id}/tags', 'attachTags');
        Route::delete('/company-updates/{id}/tags', 'detachTags');
        Route::patch('/company-updates/{id}/publish', 'publish');
    });

    Route::controller(EvaluationController::class)->group(function () {
        Route::post('/evaluations/bulk', 'bulkCreateEvaluations');
    });

    Route::controller(EquipmentTypeController::class)->group(function () {
        Route::get('/equipment-types', 'index');
        Route::post('/equipment-types', 'store');
        Route::put('/equipment-types/{id}', 'update');
        Route::delete('/equipment-types/{id}', 'destroy');
    });

    Route::controller(EquipmentController::class)->group(function () {
        Route::get('/equipment', 'index');
        Route::post('/equipment', 'store');
        Route::put('/equipment/{id}', 'update');
        Route::delete('/equipment/{id}', 'destroy');
    });

    Route::controller(EquipmentUsageController::class)->group(function () {
        Route::get('/equipment/{id}/usage', 'index');
        Route::post('/equipment/{id}/assign', 'assign');
        Route::post('/equipment/{id}/return', 'return');
    });

    Route::controller(RequestController::class)->group(function () {
        Route::patch('/requests/{id}/status', 'updateStatus');
    });
});

Route::middleware(['auth:sanctum', 'role:employee|chief_of_department|hr_employee|administrator', 'throttle:api'])->group(function () {
    Route::controller(WorkHoursController::class)->group(function () {
        Route::post('/work-hours/start', 'startWork');
        Route::post('/work-hours/end', 'endWork');
        Route::get('/work-hours/history', 'history');
    });

    Route::controller(CompanyUpdateController::class)->group(function () {
        Route::get('/company-updates', 'index');
        Route::get('/company-updates/{id}', 'show');
    });

    Route::controller(EvaluationController::class)->group(function () {
        Route::get('/evaluations', 'index');
        Route::get('/evaluations/{evaluationId}', 'show');
        Route::post('/evaluations/{evaluationId}/answers', 'answerEvaluation');
    });

    Route::controller(RequestController::class)->group(function () {
        Route::get('/requests', 'index');
        Route::get('/requests/{id}', 'show');
        Route::post('/requests', 'store');
        Route::delete('/requests/{id}', 'destroy');
    });
});

Route::middleware(['auth:sanctum', 'role:administrator|chief_of_department', 'throttle:api'])->group(function () {
    Route::controller(EvaluationController::class)->group(function () {
        Route::get('/evaluations/{userId}/compare', 'compareEvaluations');
    });
});

Route::middleware(['auth:sanctum', 'role:administrator', 'throttle:api'])->group(function () {
    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index');
        Route::put('/settings/{key}', 'update');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
        Route::post('/users/{id}/role', 'changeRole');
    });
});
