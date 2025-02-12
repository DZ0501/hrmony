<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'serial_number' => 'sometimes|string|max:255|unique:equipment,serial_number,' . $this->route('id'),
            'equipment_type_id' => 'sometimes|exists:equipment_types,id',
            'purchase_date' => 'sometimes|date',
            'warranty_until' => 'nullable|date|after_or_equal:purchase_date',
            'status' => 'sometimes|string|in:available,assigned,under_maintenance',
        ];
    }
}
