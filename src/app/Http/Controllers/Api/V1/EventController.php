<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::with(['category', 'venue', 'ticketTypes'])
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $events,
        ]);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load(['category', 'venue', 'ticketTypes']);

        return response()->json([
            'success' => true,
            'data' => $event,
        ]);
    }

    public function store(): JsonResponse
    {
        $validated = request()->validate([
            'category_id' => 'required|exists:categories,id',
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:events',
            'description' => 'required|string',
            'banner_image' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,closed',
        ]);

        $event = Event::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event,
        ], 201);
    }

    public function update(Event $event): JsonResponse
    {
        $validated = request()->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'venue_id' => 'sometimes|exists:venues,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'banner_image' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'status' => 'sometimes|in:draft,published,closed',
        ]);

        $event->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event,
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully',
        ]);
    }
}
