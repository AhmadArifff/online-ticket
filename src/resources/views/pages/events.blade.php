@extends('layouts.app')

@section('title', 'Daftar Event - Tiket Online')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Semua Event</h2>

    <!-- Filters -->
    <form method="GET" action="{{ route('events.search') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari event..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <!-- Events List -->
    <div class="row g-4">
        @forelse($events as $event)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-shadow" style="transition: transform 0.2s;">
                    <img src="{{ $event->banner_image ?: 'https://via.placeholder.com/400x200?text=' . urlencode($event->name) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-tag"></i> {{ $event->category?->name ?? 'Event' }}
                        </p>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $event->venue?->name ?? 'Lokasi' }}
                        </p>
                        <p class="card-text flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-calendar"></i> {{ $event->start_date->format('d M Y') }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="h6 mb-0 text-success">
                                Rp {{ number_format($event->ticketTypes->min('price') ?? 0, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('events.detail', $event->slug) }}" class="btn btn-sm btn-primary">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada event yang sesuai dengan pencarian Anda.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary">Kembali ke Semua Event</a>
            </div>
        @endforelse
    </div>

    @if($events instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection


    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection
