<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'sometimes|email|unique:users,email,' . $this->route('id'),
            'firstname' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|exists:roles,name',
            'sex' => 'sometimes|in:male,female',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'sometimes|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'sometimes|string|max:255',
            'postcode' => 'sometimes|string|max:20',
            'phone_no' => 'sometimes|string|max:20',
        ];
    }
}
