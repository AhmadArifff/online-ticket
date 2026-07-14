@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="number">{{ $totalEvents }}</div>
                <div class="label">Total Event</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="number">{{ $totalBookings }}</div>
                <div class="label">Total Booking</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="number">{{ $totalUsers }}</div>
                <div class="label">Total User</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="label">Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Booking Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                    <tr>
                                        <td><strong>{{ $booking->booking_code }}</strong></td>
                                        <td>{{ $booking->user?->name ?? 'Unknown' }}</td>
                                        <td>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                                        <td><span class="badge bg-{{ $booking->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($booking->status) }}</span></td>
                                        <td>{{ optional($booking->created_at)->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada booking</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Event Terpopuler</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($eventStats as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $event->name }}</span>
                                <span class="badge bg-primary">{{ $event->booking_count ?? 0 }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .stat-card .number {
        font-size: 28px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 8px;
    }
    .stat-card .label {
        color: #666;
        font-size: 14px;
    }
</style>
@endsection
