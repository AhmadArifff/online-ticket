@extends('layouts.app')

@section('title', 'Booking Saya - Tiket Online')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Booking Saya</h2>

    <div class="row">
        @php
            $bookings = [
                [
                    'code' => 'TB-20260713-0001',
                    'event' => 'Konser Musik Elektro 2026',
                    'date' => '15 Agustus 2026',
                    'tickets' => '2x Regular, 1x VIP',
                    'total' => 1050000,
                    'status' => 'paid',
                ],
                [
                    'code' => 'TB-20260713-0002',
                    'event' => 'Seminar Digital Marketing',
                    'date' => '20 Agustus 2026',
                    'tickets' => '1x Regular',
                    'total' => 350000,
                    'status' => 'pending',
                ],
                [
                    'code' => 'TB-20260713-0003',
                    'event' => 'Workshop Fotografi',
                    'date' => '25 Agustus 2026',
                    'tickets' => '1x Regular',
                    'total' => 200000,
                    'status' => 'paid',
                ],
            ];
        @endphp

        @foreach($bookings as $booking)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title">{{ $booking['event'] }}</h5>
                                <p class="text-muted mb-0">Kode: <strong>{{ $booking['code'] }}</strong></p>
                            </div>
                            <x-status-badge :status="$booking['status']" />
                        </div>

                        <p class="mb-2">
                            <i class="fas fa-calendar text-primary"></i> {{ $booking['date'] }}
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-ticket-alt text-info"></i> {{ $booking['tickets'] }}
                        </p>

                        <div class="mb-3">
                            <span class="h5 text-success">Rp {{ number_format($booking['total'], 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/my-bookings/{{ $booking['code'] }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-ticket-alt"></i> Lihat E-Ticket
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

    @if(empty($bookings))
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
            <p class="text-muted">Anda belum memiliki booking apapun.</p>
            <a href="/events" class="btn btn-primary">Jelajahi Event</a>
        </div>
    @endif
</div>
@endsection
