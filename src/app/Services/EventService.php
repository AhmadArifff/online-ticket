<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function getPublishedEvents($limit = 12, $page = 1)
    {
        return Event::with(['category', 'venue', 'ticketTypes'])
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->paginate($limit);
    }

    public function searchEvents(array $filters)
    {
        $query = Event::query()
            ->with(['category', 'venue', 'ticketTypes'])
            ->where('status', 'published');

        if (!empty($filters['q'])) {
            $query->where('name', 'like', "%{$filters['q']}%")
                ->orWhere('description', 'like', "%{$filters['q']}%");
        }

        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
            $minPrice = $filters['min_price'] ?? 0;
            $maxPrice = $filters['max_price'] ?? 99999999;

            $query->whereHas('ticketTypes', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }

        return $query->orderBy('start_date', 'asc')->paginate(12);
    }

    public function getEventDetail(Event $event)
    {
        return $event->load(['category', 'venue', 'ticketTypes']);
    }

    public function getRelatedEvents(Event $event, $limit = 3)
    {
        return Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
            ->limit($limit)
            ->get();
    }

    public function getFeaturedEvents($limit = 6)
    {
        return Event::where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->with(['category', 'venue', 'ticketTypes'])
            ->get();
    }
}
