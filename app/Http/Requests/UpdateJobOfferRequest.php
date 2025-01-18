<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position_id' => 'sometimes|exists:positions,id',
            'description' => 'sometimes|string|max:500',
            'offered_salary_min' => 'sometimes|numeric|min:0',
            'offered_salary_max' => 'sometimes|numeric|min:0',
            'job_location' => 'sometimes|string|max:255',
            'work_schedule' => 'sometimes|string|max:50',
            'work_mode' => 'sometimes|string|max:50',
            'published' => 'sometimes|boolean',
            'employment_type_ids' => 'sometimes|array',
            'employment_type_ids.*' => 'exists:employment_types,id',
        ];
    }
}
