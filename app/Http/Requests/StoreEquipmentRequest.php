<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:equipment,serial_number',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'purchase_date' => 'required|date',
            'warranty_until' => 'nullable|date|after_or_equal:purchase_date',
            'status' => 'required|string|in:available,assigned,under_maintenance',
        ];
    }
}
