<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\View\View;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
        $this->middleware('auth');
    }

    public function index(): View
    {
        $bookings = auth()->user()->bookings()
            ->with(['bookingDetails.ticketType', 'payments'])
            ->latest()
            ->paginate(10);

        return view('pages.booking-history', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);

        $booking->load(['bookingDetails.ticketType', 'payments', 'tickets']);

        return view('pages.booking-detail', compact('booking'));
    }

    public function cart(): View
    {
        return view('pages.booking-cart');
    }

    public function checkout(): View
    {
        return view('pages.booking-checkout');
    }
}
