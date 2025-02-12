<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ensure the user is authorized to submit a request
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|in:leave,remote_work,personal_data_change,equipment_request',
            'details' => 'required|array',

            // Validation for Leave Requests
            'details.reason' => 'required_if:type,leave,remote_work,equipment_request|string|max:500',
            'details.start_date' => 'required_if:type,leave|date',
            'details.end_date' => 'required_if:type,leave|date|after_or_equal:details.start_date',
            'details.leave_type' => 'required_if:type,leave|string|in:paid,leave_on_demand,unpaid,special,parental,maternity,paternity',

            // Validation for Remote Work Request
            'details.date' => 'required_if:type,remote_work|date',

            // Validation for Personal Data Change
            'details.new_data' => 'required_if:type,personal_data_change|array',

            // Validation for Equipment Request
            'details.equipment' => 'required_if:type,equipment_request|string|max:255',
        ];
    }
}
