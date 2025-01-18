<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position_id' => 'required|exists:positions,id',
            'offered_salary_min' => 'required|numeric|min:0',
            'offered_salary_max' => 'required|numeric|min:0',
            'job_location' => 'required|string|max:255',
            'published' => 'required|boolean',
            'employment_type_ids' => 'required|array',
            'employment_type_ids.*' => 'exists:employment_types,id',
            'work_mode_ids' => 'required|array',
            'work_mode_ids.*' => 'exists:work_modes,id',
            'work_schedule_ids' => 'required|array',
            'work_schedule_ids.*' => 'exists:work_schedules,id',
        ];
    }
}
