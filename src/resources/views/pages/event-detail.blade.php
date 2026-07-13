@extends('layouts.app')

@section('title', 'Detail Event - Tiket Online')

@section('content')
<div class="container-fluid">
    @php
        $event = [
            'name' => 'Konser Musik Elektro 2026',
            'category' => 'Konser',
            'description' => 'Kolaborasi musisi terbaik Indonesia dalam satu panggung yang spektakuler dengan performa luar biasa dan visual yang memukau. Event ini akan menghadirkan artis-artis ternama dan rising stars di musik elektronik Indonesia.',
            'venue' => 'Jakarta Convention Center',
            'address' => 'Jl. Gatot Subroto No. 1, Jakarta Selatan',
            'start_date' => '15 Agustus 2026',
            'end_date' => '15 Agustus 2026',
            'time' => '19:00 - 23:00',
            'price' => 250000,
            'slug' => 'konser-musik-elektro',
            'banner_image' => 'https://via.placeholder.com/800x400?text=Konser+Musik+Elektro',
            'artists' => ['DJ Andi Putra', 'DJ Santi', 'DJ Budi Oetomo'],
            'ticket_types' => [
                ['name' => 'Regular', 'price' => 250000, 'quota' => 500, 'sold' => 120],
                ['name' => 'VIP', 'price' => 500000, 'quota' => 200, 'sold' => 80],
                ['name' => 'VVIP', 'price' => 1000000, 'quota' => 50, 'sold' => 30],
            ]
        ];
    @endphp

    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Banner -->
            <img src="{{ $event['banner_image'] }}" class="img-fluid rounded mb-4" alt="{{ $event['name'] }}" style="width: 100%; height: auto;">

            <!-- Event Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $event['name'] }}</h2>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt text-danger"></i> Lokasi:</strong></p>
                            <p>{{ $event['venue'] }}<br>{{ $event['address'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar text-primary"></i> Tanggal & Waktu:</strong></p>
                            <p>{{ $event['start_date'] }}<br>{{ $event['time'] }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5>Tentang Event</h5>
                    <p>{{ $event['description'] }}</p>

                    <h5 class="mt-4">Artis Pembawaan</h5>
                    <ul>
                        @foreach($event['artists'] as $artist)
                            <li>{{ $artist }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar - Ticket Selection -->
        <div class="col-lg-4">
            <div class="card sticky-top">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pilih Jenis Tiket</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/checkout">
                        @csrf
                        <input type="hidden" name="event_id" value="1">

                        @foreach($event['ticket_types'] as $ticket)
                            <div class="mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">{{ $ticket['name'] }}</label>
                                    <span class="badge bg-info">{{ $ticket['quota'] - $ticket['sold'] }} tersedia</span>
                                </div>
                                
                                <p class="text-muted mb-2">Rp {{ number_format($ticket['price'], 0, ',', '.') }}</p>
                                
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary qty-minus" data-ticket="{{ $ticket['name'] }}">-</button>
                                    <input type="number" class="form-control text-center qty-input" name="qty_{{ strtolower($ticket['name']) }}" value="0" min="0" data-price="{{ $ticket['price'] }}">
                                    <button type="button" class="btn btn-outline-secondary qty-plus" data-ticket="{{ $ticket['name'] }}">+</button>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <div class="mb-3">
                            <p>Total Harga: <span class="h4 text-success" id="total-price">Rp 0</span></p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">Lanjut ke Checkout</button>
                        <a href="/events" class="btn btn-secondary w-100 mt-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.qty-input').forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseInt(input.dataset.price) || 0;
            total += qty * price;
        });
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const ticket = this.dataset.ticket;
            const input = document.querySelector(`input[name="qty_${ticket.toLowerCase()}"]`);
            if (input && parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        });
    });

    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const ticket = this.dataset.ticket;
            const input = document.querySelector(`input[name="qty_${ticket.toLowerCase()}"]`);
            if (input) {
                input.value = parseInt(input.value) + 1;
                updateTotal();
            }
        });
    });

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', updateTotal);
    });

    updateTotal();
</script>
@endpush
@endsection
