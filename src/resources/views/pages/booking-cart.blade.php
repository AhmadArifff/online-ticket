@extends('layouts.app')

@section('title', 'Keranjang - Tiket Online')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card py-5 text-center">
                <div class="card-body">
                    <h2 class="mb-3">Keranjang Anda</h2>
                    <p class="text-muted mb-4">Fitur keranjang akan segera tersedia. Sementara itu, lanjutkan langsung ke halaman checkout untuk menyelesaikan pemesanan.</p>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Lanjut ke Checkout</a>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary ms-2">Kembali ke Event</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
