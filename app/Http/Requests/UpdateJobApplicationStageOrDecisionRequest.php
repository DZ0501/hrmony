<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobApplicationStageOrDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stage' => 'sometimes|in:hr_review,department_head_review',
            'decision' => 'sometimes|in:pending,opened,passed,rejected',
        ];
    }
}
