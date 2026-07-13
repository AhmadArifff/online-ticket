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
            @php
                $events = [
                    [
                        'name' => 'Konser Musik Elektro 2026',
                        'category' => 'Konser',
                        'description' => 'Kolaborasi musisi terbaik Indonesia dalam satu panggung yang spektakuler.',
                        'venue' => 'Jakarta Convention Center',
                        'start_date' => '15 Agustus 2026',
                        'price' => 250000,
                        'slug' => 'konser-musik-elektro',
                        'banner_image' => 'https://via.placeholder.com/400x200?text=Konser+Musik',
                    ],
                    [
                        'name' => 'Seminar Digital Marketing',
                        'category' => 'Seminar',
                        'description' => 'Pelajari strategi marketing digital terkini dari expert internasional.',
                        'venue' => 'Gran Melia Hotel',
                        'start_date' => '20 Agustus 2026',
                        'price' => 350000,
                        'slug' => 'seminar-digital-marketing',
                        'banner_image' => 'https://via.placeholder.com/400x200?text=Seminar',
                    ],
                    [
                        'name' => 'Pertandingan Basket Pro',
                        'category' => 'Olahraga',
                        'description' => 'Pertandingan puncak musim basket profesional Indonesia.',
                        'venue' => 'Istora Senayan',
                        'start_date' => '22 Agustus 2026',
                        'price' => 150000,
                        'slug' => 'pertandingan-basket-pro',
                        'banner_image' => 'https://via.placeholder.com/400x200?text=Basket',
                    ],
                    [
                        'name' => 'Workshop Fotografi',
                        'category' => 'Workshop',
                        'description' => 'Sesi workshop fotografi profesional dengan fotografer terkenal.',
                        'venue' => 'Art Space Studio',
                        'start_date' => '25 Agustus 2026',
                        'price' => 200000,
                        'slug' => 'workshop-fotografi',
                        'banner_image' => 'https://via.placeholder.com/400x200?text=Workshop',
                    ],
                ];
            @endphp
            
            @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-3">
                    <x-event-card :event="$event" />
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
