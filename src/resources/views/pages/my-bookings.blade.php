@extends('layouts.app')

@section('title', 'Booking Saya - Tiket Online')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Booking Saya</h2>

    @if($bookings->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
            <p class="text-muted">Anda belum memiliki booking apapun.</p>
            <a href="/events" class="btn btn-primary">Jelajahi Event</a>
        </div>
    @else
        <div class="row">
            @foreach($bookings as $booking)
                @php
                    $eventName = $booking->bookingDetails->first()?->ticketType?->event?->name ?? 'Event Tidak Diketahui';
                    $ticketSummary = $booking->bookingDetails->map(function ($detail) {
                        return $detail->quantity . 'x ' . $detail->ticketType->name;
                    })->implode(', ');
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title">{{ $eventName }}</h5>
                                    <p class="text-muted mb-0">Kode: <strong>{{ $booking->booking_code }}</strong></p>
                                </div>
                                <x-status-badge :status="$booking->status" />
                            </div>

                            <p class="mb-2">
                                <i class="fas fa-calendar text-primary"></i>
                                {{ optional($booking->created_at)->format('d F Y') ?? '-' }}
                            </p>
                            <p class="mb-3">
                                <i class="fas fa-ticket-alt text-info"></i> {{ $ticketSummary ?: 'Belum ada tiket' }}
                            </p>

                            <div class="mb-3">
                                <span class="h5 text-success">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('bookings.detail', $booking) }}" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-ticket-alt"></i> Lihat Detail
                                </a>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i> Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
