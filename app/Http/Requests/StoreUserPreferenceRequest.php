<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Preference;

class StoreUserPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'preferences' => 'required|array',
            'preferences.*.preference_id' => [
                'required',
                'exists:preferences,id',
            ],
            'preferences.*.value' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $preference = Preference::find($this->input(str_replace('value', 'preference_id', $attribute)));

                    if ($preference) {
                        $enum = $preference->getEnum();
                        if ($enum && !in_array($value, $enum->validValues(), true)) {
                            $fail("The value for preference '{$preference->name}' is invalid. Allowed values are: " . implode(', ', $enum->validValues()));
                        }
                    } else {
                        $fail("Invalid preference ID.");
                    }
                },
            ],
        ];
    }
}
