<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncResponsibilitiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules(): array
    {
        return [
            'responsibility_ids' => 'array',
            'responsibility_ids.*' => 'exists:responsibilities,id',
        ];
    }
}
