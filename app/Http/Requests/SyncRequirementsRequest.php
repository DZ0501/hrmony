<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncRequirementsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules(): array
    {
        return [
            'requirement_ids' => 'array',
            'requirement_ids.*' => 'exists:requirements,id',
        ];
    }
}
