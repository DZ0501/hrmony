<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ensure route-level middleware handles permissions
    }

    public function rules(): array
    {
        return [
            'department_id' => 'required|exists:departments,id',
        ];
    }
}
