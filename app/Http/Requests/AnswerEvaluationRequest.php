<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class AnswerEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.rating' => 'required|integer|between:1,5',
            'answers.*.comment' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $requiredQuestions = Question::where('type', 'evaluation')->pluck('id')->toArray();
            $providedQuestions = collect($this->answers)->pluck('question_id')->toArray();

            if (array_diff($requiredQuestions, $providedQuestions)) {
                $validator->errors()->add('answers', 'All evaluation questions must be answered.');
            }
        });
    }
}
