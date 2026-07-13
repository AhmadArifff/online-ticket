@extends('layouts.admin')

@section('title', 'Dashboard Admin - Tiket Online')

@section('content')
<h2 class="mb-4">Dashboard Admin</h2>

<!-- KPI Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Event</h6>
                <h2 class="mb-0">24</h2>
                <small>Aktif minggu ini: 8</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total Booking</h6>
                <h2 class="mb-0">342</h2>
                <small>Revenue: Rp 150.3 Juta</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Tiket Terjual</h6>
                <h2 class="mb-0">1.242</h2>
                <small>+25% dari bulan lalu</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">User Aktif</h6>
                <h2 class="mb-0">532</h2>
                <small>+12% dari bulan lalu</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Penjualan Tiket (30 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <div style="height: 300px; background: linear-gradient(to top, rgba(102, 126, 234, 0.1), rgba(102, 126, 234, 0.3)); border-radius: 5px; display: flex; align-items: flex-end; gap: 5px; padding: 10px;">
                    @for($i = 0; $i < 30; $i++)
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 100%; height: {{ rand(30, 95) }}%; border-radius: 3px;"></div>
                    @endfor
                </div>
                <p class="text-muted text-center mt-3 mb-0">Grafik penjualan tiket 30 hari terakhir</p>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Event Teratas</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Tiket Terjual</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Konser Musik Elektro 2026</td>
                            <td><span class="badge bg-success">450</span></td>
                            <td>Rp 87.5 Juta</td>
                        </tr>
                        <tr>
                            <td>Seminar Digital Marketing</td>
                            <td><span class="badge bg-success">380</span></td>
                            <td>Rp 48.2 Juta</td>
                        </tr>
                        <tr>
                            <td>Workshop Fotografi</td>
                            <td><span class="badge bg-info">280</span></td>
                            <td>Rp 32.1 Juta</td>
                        </tr>
                        <tr>
                            <td>Pertandingan Basket Pro</td>
                            <td><span class="badge bg-warning">200</span></td>
                            <td>Rp 12.5 Juta</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Booking Terbaru</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Customer</th>
                    <th>Event</th>
                    <th>Jumlah Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TB-20260713-0001</td>
                    <td>John Doe</td>
                    <td>Konser Musik Elektro 2026</td>
                    <td>3</td>
                    <td>Rp 1.050.000</td>
                    <td><span class="badge bg-success">Dibayar</span></td>
                </tr>
                <tr>
                    <td>TB-20260713-0002</td>
                    <td>Jane Smith</td>
                    <td>Seminar Digital Marketing</td>
                    <td>2</td>
                    <td>Rp 700.000</td>
                    <td><span class="badge bg-warning">Menunggu</span></td>
                </tr>
                <tr>
                    <td>TB-20260713-0003</td>
                    <td>Bob Wilson</td>
                    <td>Workshop Fotografi</td>
                    <td>1</td>
                    <td>Rp 210.000</td>
                    <td><span class="badge bg-success">Dibayar</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
