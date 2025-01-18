<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_offer_id' => 'required|exists:job_offers,id',
            'answers' => 'required|array|min:5',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer' => 'required|string|max:1000',
        ];
    }
}
