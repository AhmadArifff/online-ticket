@extends('layouts.app')

@section('title', $event->name . ' - Tiket Online')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Banner -->
            <img src="{{ $event->banner_image ?: 'https://via.placeholder.com/800x400?text=' . urlencode($event->name) }}" class="img-fluid rounded mb-4" alt="{{ $event->name }}" style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">

            <!-- Event Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $event->name }}</h2>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag text-secondary"></i> Kategori:</strong></p>
                            <p>{{ $event->category?->name ?? 'Event' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt text-danger"></i> Lokasi:</strong></p>
                            <p>{{ $event->venue?->name ?? 'Lokasi TBA' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar text-primary"></i> Tanggal Mulai:</strong></p>
                            <p>{{ optional($event->start_date)->format('d F Y H:i') ?? 'TBA' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar-check text-success"></i> Tanggal Berakhir:</strong></p>
                            <p>{{ optional($event->end_date)->format('d F Y H:i') ?? 'TBA' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5>Tentang Event</h5>
                    <p>{{ $event->description }}</p>
                </div>
            </div>

            <!-- Related Events -->
            @if($relatedEvents->count())
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Event Terkait</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($relatedEvents as $related)
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <img src="{{ $related->banner_image ?: 'https://via.placeholder.com/300x150?text=' . urlencode($related->name) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $related->name }}</h6>
                                            <p class="text-muted small">{{ optional($related->start_date)->format('d M Y') }}</p>
                                            <a href="{{ route('events.detail', $related->slug) }}" class="btn btn-sm btn-primary">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - Ticket Selection -->
        <div class="col-lg-4">
            <div class="card sticky-top">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pilih Jenis Tiket</h5>
                </div>
                <div class="card-body">
                    @if($event->ticketTypes->isEmpty())
                        <p class="text-muted text-center py-4">Tiket belum tersedia untuk event ini.</p>
                    @else
                        <form method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            @foreach($event->ticketTypes as $ticketType)
                                @php
                                    $available = ($ticketType->quota ?? 0) - ($ticketType->sold ?? 0);
                                @endphp
                                <div class="mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold mb-0">{{ $ticketType->name }}</label>
                                        <span class="badge bg-info">{{ $available }} tersedia</span>
                                    </div>
                                    
                                    <p class="text-muted mb-2">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</p>
                                    
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary qty-minus" data-ticket="{{ $ticketType->id }}">-</button>
                                        <input type="number" class="form-control text-center qty-input" name="qty_{{ $ticketType->id }}" value="0" min="0" max="{{ $available }}" data-price="{{ $ticketType->price }}">
                                        <button type="button" class="btn btn-outline-secondary qty-plus" data-ticket="{{ $ticketType->id }}">+</button>
                                    </div>
                                </div>
                            @endforeach

                            <hr>

                            <div class="mb-3">
                                <p>Total Harga: <span class="h4 text-success" id="total-price">Rp 0</span></p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg" id="checkout-btn" disabled>Lanjut ke Checkout</button>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary w-100 mt-2">Kembali</a>
                        </form>
                    @endif
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
