<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'venue_id' => 'sometimes|exists:venues,id',
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:events,slug,' . $this->event->id . '|max:255',
            'description' => 'sometimes|string',
            'banner_image' => 'nullable|string',
            'start_date' => 'sometimes|date|after_or_equal:today',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => 'sometimes|in:draft,published,closed',
        ];
    }
}
