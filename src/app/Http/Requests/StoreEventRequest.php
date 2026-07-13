<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:events|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,closed',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Category is required',
            'venue_id.required' => 'Venue is required',
            'name.required' => 'Event name is required',
            'slug.unique' => 'Event slug already exists',
            'start_date.after_or_equal' => 'Start date must be today or later',
            'end_date.after' => 'End date must be after start date',
        ];
    }
}
