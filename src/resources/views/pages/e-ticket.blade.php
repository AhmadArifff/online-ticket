@extends('layouts.app')

@section('title', 'E-Ticket - Tiket Online')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h3 class="mb-4">E-Ticket</h3>
                    
                    <div class="mb-4 p-4 bg-light rounded">
                        <p class="text-muted mb-1">Kode Booking</p>
                        <h4 class="mb-0">TB-20260713-0001</h4>
                    </div>

                    <div class="mb-4">
                        <h5>Konser Musik Elektro 2026</h5>
                        <p class="text-muted mb-0">Jakarta Convention Center</p>
                    </div>

                    <!-- QR Code -->
                    <div class="mb-4 p-4 bg-light rounded">
                        <img src="https://via.placeholder.com/250x250?text=QR+CODE" alt="QR Code" class="img-fluid">
                    </div>

                    <!-- Ticket Details -->
                    <table class="table">
                        <tr>
                            <td><strong>Tanggal Event</strong></td>
                            <td>15 Agustus 2026</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu</strong></td>
                            <td>19:00 - 23:00</td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Tiket</strong></td>
                            <td>3 Tiket</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td><x-status-badge status="paid" /></td>
                        </tr>
                    </table>

                    <!-- List Tiket -->
                    <div class="mt-4 text-start">
                        <h6>Daftar Tiket</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Tiket #1 - Regular</strong></p>
                                        <small class="text-muted">Nama: John Doe</small>
                                    </div>
                                    <span class="badge bg-info">001</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Tiket #2 - Regular</strong></p>
                                        <small class="text-muted">Nama: Jane Doe</small>
                                    </div>
                                    <span class="badge bg-info">002</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Tiket #3 - VIP</strong></p>
                                        <small class="text-muted">Nama: John Doe</small>
                                    </div>
                                    <span class="badge bg-success">VIP001</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary w-100 mb-2" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak E-Ticket
                        </button>
                        <a href="/my-bookings" class="btn btn-secondary w-100">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
