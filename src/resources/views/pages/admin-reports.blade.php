@extends('layouts.admin')

@section('title', 'Reports - Admin Panel')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Laporan</h3>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="label">Total Revenue</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="number">{{ $totalBookings }}</div>
                <div class="label">Total Bookings</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="number">{{ $pendingPayments }}</div>
                <div class="label">Pending Payments</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Ringkasan Pendapatan</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">Total revenue dari semua booking yang telah dibayar adalah Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-muted">Dengan total {{ $totalBookings }} booking dan {{ $pendingPayments }} booking yang masih pending pembayaran.</p>
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
        font-size: 24px;
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
