@extends('layouts.app')

@section('title', 'Beranda - Tiket Online')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <section class="hero mb-5 py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-3">Temukan Event Terbaik</h1>
                    <p class="lead mb-4">Pesan tiket untuk konser, seminar, dan event favorit Anda dengan mudah dan aman.</p>
                    <a href="/events" class="btn btn-light btn-lg">Jelajahi Event</a>
                </div>
                <div class="col-md-6 text-center">
                    <i class="fas fa-tickets-alt fa-10x" style="opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="mb-5">
        <h3 class="mb-4">Event Terbaru</h3>
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Cari event...">
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="konser">Konser</option>
                    <option value="seminar">Seminar</option>
                    <option value="pertandingan">Pertandingan</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control">
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section>
        <div class="row g-4">
            @forelse($featuredEvents as $event)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm hover-shadow" style="transition: transform 0.2s;">
                        <img src="{{ $event->banner_image ?: 'https://via.placeholder.com/400x200?text=' . urlencode($event->name) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="text-muted small mb-2">{{ $event->category?->name ?? 'Event' }}</p>
                            <p class="card-text flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
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
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada event yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
