@props(['event'])

<div class="card h-100 shadow-sm">
    @if($event['banner_image'])
        <img src="{{ $event['banner_image'] }}" class="card-img-top" alt="{{ $event['name'] }}" style="height: 200px; object-fit: cover;">
    @else
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="fas fa-image fa-3x text-muted"></i>
        </div>
    @endif
    
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="card-title">{{ $event['name'] }}</h5>
            <span class="badge bg-info">{{ $event['category'] }}</span>
        </div>
        
        <p class="card-text text-muted small">{{ Str::limit($event['description'], 80) }}</p>
        
        <div class="mb-3">
            <p class="mb-1"><i class="fas fa-map-marker-alt text-danger"></i> {{ $event['venue'] }}</p>
            <p class="mb-0"><i class="fas fa-calendar text-primary"></i> {{ $event['start_date'] }}</p>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <span class="h5 mb-0 text-success">Rp {{ number_format($event['price'], 0, ',', '.') }}</span>
            <a href="/events/{{ $event['slug'] }}" class="btn btn-sm btn-primary">Detail</a>
        </div>
    </div>
</div>
