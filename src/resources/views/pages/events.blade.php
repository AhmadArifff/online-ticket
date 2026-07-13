@extends('layouts.app')

@section('title', 'Daftar Event - Tiket Online')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Semua Event</h2>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Cari event...">
        </div>
        <div class="col-md-4">
            <select class="form-select">
                <option value="">Semua Kategori</option>
                <option value="konser">Konser</option>
                <option value="seminar">Seminar</option>
                <option value="olahraga">Olahraga</option>
                <option value="workshop">Workshop</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" class="form-control" placeholder="Pilih Tanggal">
        </div>
    </div>

    <!-- Events List -->
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
                [
                    'name' => 'Festival Kuliner Internasional',
                    'category' => 'Festival',
                    'description' => 'Nikmati kuliner terbaik dari berbagai negara di festival tahunan ini.',
                    'venue' => 'Monas Bundaran',
                    'start_date' => '28 Agustus 2026',
                    'price' => 75000,
                    'slug' => 'festival-kuliner',
                    'banner_image' => 'https://via.placeholder.com/400x200?text=Festival',
                ],
                [
                    'name' => 'Pameran Seni Kontemporer',
                    'category' => 'Seni',
                    'description' => 'Pameran karya seni kontemporer dari seniman lokal dan internasional.',
                    'venue' => 'Art Gallery Indonesia',
                    'start_date' => '01 September 2026',
                    'price' => 100000,
                    'slug' => 'pameran-seni',
                    'banner_image' => 'https://via.placeholder.com/400x200?text=Seni',
                ],
            ];
        @endphp
        
        @foreach($events as $event)
            <div class="col-12 col-md-6 col-lg-4">
                <x-event-card :event="$event" />
            </div>
        @endforeach
    </div>

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
