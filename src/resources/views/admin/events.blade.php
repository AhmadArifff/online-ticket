@extends('layouts.admin')

@section('title', 'Kelola Event - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Event</h2>
    <a href="/admin/events/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Event
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Tiket Terjual</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $eventsList = [
                        ['name' => 'Konser Musik Elektro 2026', 'category' => 'Konser', 'date' => '15 Agustus 2026', 'venue' => 'Jakarta Convention Center', 'sold' => 450, 'status' => 'published'],
                        ['name' => 'Seminar Digital Marketing', 'category' => 'Seminar', 'date' => '20 Agustus 2026', 'venue' => 'Gran Melia Hotel', 'sold' => 380, 'status' => 'published'],
                        ['name' => 'Workshop Fotografi', 'category' => 'Workshop', 'date' => '25 Agustus 2026', 'venue' => 'Art Space Studio', 'sold' => 280, 'status' => 'published'],
                        ['name' => 'Festival Kuliner Internasional', 'category' => 'Festival', 'date' => '28 Agustus 2026', 'venue' => 'Monas Bundaran', 'sold' => 0, 'status' => 'draft'],
                    ];
                @endphp
                
                @foreach($eventsList as $event)
                    <tr>
                        <td><strong>{{ $event['name'] }}</strong></td>
                        <td>{{ $event['category'] }}</td>
                        <td>{{ $event['date'] }}</td>
                        <td>{{ $event['venue'] }}</td>
                        <td><span class="badge bg-info">{{ $event['sold'] }}</span></td>
                        <td>
                            @if($event['status'] === 'published')
                                <span class="badge bg-success">Dipublikasikan</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/events/1/edit" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
