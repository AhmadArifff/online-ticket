<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\User;
use Illuminate\View\View;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $totalEvents = Event::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'paid')->sum('total_amount');
        $totalUsers = User::where('role', 'customer')->count();

        $recentBookings = Booking::with(['user', 'payments'])
            ->latest()
            ->limit(10)
            ->get();

        $eventStats = Event::selectRaw('id, name, (SELECT COUNT(*) FROM booking_details WHERE event_id = events.id) as booking_count')
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.admin-dashboard', compact(
            'totalEvents',
            'totalBookings',
            'totalRevenue',
            'totalUsers',
            'recentBookings',
            'eventStats'
        ));
    }

    public function eventsIndex(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $events = Event::with(['category', 'venue'])
            ->latest()
            ->paginate(15);

        return view('pages.admin-events', compact('events'));
    }

    public function eventCreate(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('pages.admin-event-create');
    }

    public function eventEdit(Event $event): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $event->load(['category', 'venue', 'ticketTypes']);

        return view('pages.admin-event-edit', compact('event'));
    }

    public function storeEvent(StoreEventRequest $request): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $event = Event::create($request->validated());

        $this->toast('Event created successfully', 'success');

        return redirect()->route('admin.events.index');
    }

    public function updateEvent(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $event->update($request->validated());

        $this->toast('Event updated successfully', 'success');

        return redirect()->route('admin.events.index');
    }

    public function destroyEvent(Event $event): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $event->delete();

        $this->toast('Event deleted', 'info');

        return redirect()->route('admin.events.index');
    }

    // Store new event (web)
    public function eventStore(\App\Http\Requests\StoreEventRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validated();
        $event = Event::create($data);

        session()->flash('toast', ['message' => 'Event created successfully', 'type' => 'success']);

        return redirect()->route('admin.events.index');
    }

    // Update existing event (web)
    public function eventUpdate(\App\Http\Requests\UpdateEventRequest $request, Event $event)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validated();
        $event->update($data);

        session()->flash('toast', ['message' => 'Event updated successfully', 'type' => 'success']);

        return redirect()->route('admin.events.index');
    }

    // Delete event (web)
    public function eventDestroy(Event $event)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $event->delete();

        session()->flash('toast', ['message' => 'Event deleted', 'type' => 'info']);

        return redirect()->route('admin.events.index');
    }

    public function bookingsIndex(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $bookings = Booking::with(['user', 'payments'])
            ->latest()
            ->paginate(15);

        return view('pages.admin-bookings', compact('bookings'));
    }

    public function reports(): View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $totalRevenue = Booking::where('status', 'paid')->sum('total_amount');
        $totalBookings = Booking::count();
        $pendingPayments = Booking::where('status', 'pending')->count();

        return view('pages.admin-reports', compact(
            'totalRevenue',
            'totalBookings',
            'pendingPayments'
        ));
    }
}
