@extends('layouts.app')

@section('title', 'Detail Booking - Tiket Online')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h2 class="mb-4">Detail Booking</h2>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="card-title mb-1">Booking #{{ $booking->booking_code }}</h4>
                            <p class="text-muted mb-1">Status: <strong>{{ ucfirst($booking->status) }}</strong></p>
                            <p class="text-muted">Tanggal Booking: {{ optional($booking->created_at)->format('d F Y H:i') ?? '-' }}</p>
                        </div>
                        <x-status-badge :status="$booking->status" />
                    </div>

                    <hr>

                    <h5 class="mb-3">Rincian Tiket</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Tiket</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->bookingDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->ticketType->name ?? 'Tiket Tidak Diketahui' }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <p class="mb-1"><strong>Total Pembayaran:</strong></p>
                        <h4 class="text-success">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</h4>
                    </div>

                    <div class="mb-4">
                        <h5>Riwayat Transaksi</h5>
                        @if($booking->payments->isEmpty())
                            <p class="text-muted">Belum ada pembayaran tercatat.</p>
                        @else
                            <ul class="list-group">
                                @foreach($booking->payments as $payment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ ucfirst($payment->status ?? 'unknown') }} - {{ optional($payment->created_at)->format('d F Y H:i') }}</span>
                                        <span>Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali ke Booking Saya</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
