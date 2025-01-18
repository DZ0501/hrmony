<?php

namespace App\Services;

use App\Events\PasswordResetRequested;
use App\Events\UserRegistered;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function registerUser(array $data): User
    {
        $user = User::create([
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('candidate');

        UserDetail::create([
            'user_id' => $user->id,
            'sex' => $data['sex'],
            'department' => $data['department'] ?? null,
            'position' => $data['position'] ?? null,
            'address' => $data['address'],
            'address2' => $data['address2'] ?? null,
            'city' => $data['city'],
            'postcode' => $data['postcode'],
            'phone_no' => $data['phone_no'],
        ]);

        $this->attachDefaultPreferences($user);

        UserRegistered::dispatch($user);

        return $user;
    }

    protected function attachDefaultPreferences(User $user): void
    {
        $defaultPreferences = [
            ['preference_id' => 1, 'value' => 'light'],
            ['preference_id' => 2, 'value' => 'yes'],
        ];

        foreach ($defaultPreferences as $preference) {
            $user->preferences()->attach($preference['preference_id'], ['value' => $preference['value']]);
        }
    }


    public function loginUser(array $data): ?string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        if (!$user->hasVerifiedEmail()) {
            throw new \Exception('Your email address is not verified.');
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logoutUser(User $user): void
    {
        $user->tokens()->delete();
    }

    public function verifyEmail(int $id, string $hash): void
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            throw ValidationException::withMessages([
                'link' => ['Invalid or expired verification link.'],
            ]);
        }

        $user->markEmailAsVerified();
    }

    public function resendVerificationEmail(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => ['Email is already verified.'],
            ]);
        }

        $user->sendEmailVerificationNotification();
    }

    public function sendPasswordResetLink(string $email): void
    {
        $status = Password::createToken(User::where('email', $email)->first());

        if (!$status) {
            throw new \Exception('Failed to generate password reset token.');
        }

        PasswordResetRequested::dispatch($email, $status);
    }


    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                $user->tokens()->delete();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new \Exception('Failed to reset password.');
        }
    }
}
