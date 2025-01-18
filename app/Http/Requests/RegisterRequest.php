<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Routes are secured
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'sex' => 'required|in:male,female',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'city' => 'required|string|max:50',
            'postcode' => 'required|string|max:20',
            'phone_no' => 'required|string|max:20',
        ];
    }
}

