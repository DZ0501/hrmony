<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResendVerificationRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\AuthService;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $user = $this->authService->registerUser($request->validated());

            return new ApiSuccessResponse(
                data: $user,
                message: ['User registered successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to register user.']
            );
        }
    }

    public function login(LoginRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $token = $this->authService->loginUser($request->validated());

            if (!$token) {
                return new ApiErrorResponse(
                    exception: null,
                    message: ['The provided credentials are incorrect.'],
                    status: 422
                );
            }

            return new ApiSuccessResponse(
                data: [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
                message: ['Login successful.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to log in.']
            );
        }
    }

   public function logout(Request $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->authService->logoutUser($request->user());

            return new ApiSuccessResponse(
                data: null,
                message: ['Logged out successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to log out.']
            );
        }
    }

    public function verify($id, $hash): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->authService->verifyEmail($id, $hash);

            return new ApiSuccessResponse(
                data: null,
                message: ['Email verified successfully. You can now log in.']
            );
        } catch (ValidationException $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: $e->errors(),
                status: 403
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to verify email.']
            );
        }
    }

    public function resend(ResendVerificationRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->authService->resendVerificationEmail($request->validated()['email']);

            return new ApiSuccessResponse(
                data: null,
                message: ['Verification email resent.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to resend verification email.']
            );
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->authService->sendPasswordResetLink($request->validated()['email']);

            return new ApiSuccessResponse(
                data: null,
                message: ['Password reset link sent successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to send password reset link.']
            );
        }
    }

    public function resetPassword(ResetPasswordRequest $request): ApiErrorResponse|ApiSuccessResponse
    {
        try {
            $this->authService->resetPassword($request->validated());

            return new ApiSuccessResponse(
                data: null,
                message: ['Password reset successfully.']
            );
        } catch (\Throwable $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: ['Failed to reset password.']
            );
        }
    }
}
