@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Admin')

@section('content')
<h2 class="mb-4">Laporan Penjualan</h2>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Periode Awal</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Periode Akhir</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option value="">Semua</option>
                    <option value="paid">Dibayar</option>
                    <option value="pending">Menunggu</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total Revenue</h6>
                <h2>Rp 150.3 Juta</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Total Booking</h6>
                <h2>342</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Total Tiket</h6>
                <h2>1.242</h2>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Report -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Laporan</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Event</th>
                    <th>Booking</th>
                    <th>Tiket</th>
                    <th>Total Revenue</th>
                    <th>Status Bayar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>13 Juli 2026</td>
                    <td>Konser Musik Elektro 2026</td>
                    <td>45</td>
                    <td>125</td>
                    <td>Rp 28.5 Juta</td>
                    <td><span class="badge bg-success">Dibayar</span></td>
                </tr>
                <tr>
                    <td>13 Juli 2026</td>
                    <td>Seminar Digital Marketing</td>
                    <td>32</td>
                    <td>85</td>
                    <td>Rp 18.2 Juta</td>
                    <td><span class="badge bg-success">Dibayar</span></td>
                </tr>
                <tr>
                    <td>12 Juli 2026</td>
                    <td>Workshop Fotografi</td>
                    <td>28</td>
                    <td>72</td>
                    <td>Rp 12.1 Juta</td>
                    <td><span class="badge bg-warning">Menunggu</span></td>
                </tr>
                <tr>
                    <td>11 Juli 2026</td>
                    <td>Pertandingan Basket Pro</td>
                    <td>18</td>
                    <td>45</td>
                    <td>Rp 5.2 Juta</td>
                    <td><span class="badge bg-success">Dibayar</span></td>
                </tr>
                <tr class="table-active fw-bold">
                    <td colspan="3">TOTAL</td>
                    <td>327</td>
                    <td>Rp 64 Juta</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <button class="btn btn-outline-primary">
        <i class="fas fa-download"></i> Export PDF
    </button>
    <button class="btn btn-outline-secondary">
        <i class="fas fa-file-excel"></i> Export Excel
    </button>
</div>
@endsection
