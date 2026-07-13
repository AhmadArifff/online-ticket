<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.ticket_type_id' => 'required|integer|exists:ticket_types,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one ticket type must be selected',
            'items.min' => 'At least one ticket type must be selected',
            'items.*.ticket_type_id.required' => 'Ticket type is required',
            'items.*.ticket_type_id.exists' => 'Selected ticket type does not exist',
            'items.*.quantity.required' => 'Quantity is required',
            'items.*.quantity.min' => 'Minimum quantity is 1',
            'items.*.quantity.max' => 'Maximum quantity is 100',
        ];
    }
}
