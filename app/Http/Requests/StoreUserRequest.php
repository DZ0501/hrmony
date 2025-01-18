<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'sex' => 'required|in:male,female',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'phone_no' => 'required|string|max:20',
        ];
    }
}
