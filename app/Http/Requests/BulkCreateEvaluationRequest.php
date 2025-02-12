<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quarter' => 'required|integer|between:1,4',
            'year' => 'required|integer|min:2000|max:' . now()->year,
        ];
    }
}
