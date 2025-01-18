<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255|unique:positions,name,' . $this->route('id'),
            'description' => 'sometimes|string',
        ];
    }
}
