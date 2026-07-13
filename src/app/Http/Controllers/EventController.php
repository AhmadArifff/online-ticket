<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Services\EventService;
use Illuminate\View\View;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function home(): View
    {
        $featuredEvents = $this->eventService->getFeaturedEvents(6);
        $categories = Category::all();

        return view('pages.home', compact('featuredEvents', 'categories'));
    }

    public function index(): View
    {
        $events = $this->eventService->getPublishedEvents(6);
        $categories = Category::all();

        return view('pages.events', compact('events', 'categories'));
    }

    public function show(Event $event): View
    {
        $event = $this->eventService->getEventDetail($event);
        $relatedEvents = $this->eventService->getRelatedEvents($event, 3);

        return view('pages.event-detail', compact('event', 'relatedEvents'));
    }

    public function search(): View
    {
        $query = request()->get('q', '');
        $category = request()->get('category', '');
        $minPrice = request()->get('min_price', 0);
        $maxPrice = request()->get('max_price', 9999999);

        $events = $this->eventService->searchEvents([
            'q' => $query,
            'category' => $category,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);

        $categories = Category::all();

        return view('pages.event-search', compact('events', 'categories', 'query'));
    }
}
