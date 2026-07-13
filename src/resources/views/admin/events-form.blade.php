@extends('layouts.admin')

@section('title', 'Form Event - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ isset($id) ? 'Edit Event' : 'Tambah Event Baru' }}</h2>
    <a href="/admin/events" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Event Name -->
                    <div class="mb-3">
                        <label class="form-label">Nama Event</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="name"
                            placeholder="Masukkan nama event"
                            value="Konser Musik Elektro 2026"
                            required
                        >
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="slug"
                            placeholder="konser-musik-elektro-2026"
                            value="konser-musik-elektro-2026"
                            required
                        >
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <option value="1" selected>Konser</option>
                            <option value="2">Seminar</option>
                            <option value="3">Workshop</option>
                            <option value="4">Olahraga</option>
                            <option value="5">Festival</option>
                        </select>
                    </div>

                    <!-- Venue -->
                    <div class="mb-3">
                        <label class="form-label">Lokasi/Venue</label>
                        <select class="form-select" name="venue_id" required>
                            <option value="">Pilih Venue</option>
                            <option value="1" selected>Jakarta Convention Center</option>
                            <option value="2">Gran Melia Hotel</option>
                            <option value="3">Art Space Studio</option>
                            <option value="4">Monas Bundaran</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea 
                            class="form-control" 
                            name="description" 
                            rows="5"
                            placeholder="Masukkan deskripsi event"
                        >Konser musik elektro terbesar dengan artis internasional. Nikmati pengalaman musik elektronik yang tak terlupakan.</textarea>
                    </div>

                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input 
                                type="datetime-local" 
                                class="form-control" 
                                name="start_date"
                                value="2026-08-15T18:00"
                                required
                            >
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input 
                                type="datetime-local" 
                                class="form-control" 
                                name="end_date"
                                value="2026-08-15T23:00"
                                required
                            >
                        </div>
                    </div>

                    <!-- Banner Image -->
                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>
                        <input 
                            type="file" 
                            class="form-control" 
                            name="banner_image"
                            accept="image/*"
                        >
                        <small class="text-muted">Rekomendasi: 1200x400px, Max 2MB</small>
                    </div>

                    <!-- Published Status -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="published" 
                                name="published"
                                checked
                            >
                            <label class="form-check-label" for="published">
                                Publikasikan event ini
                            </label>
                        </div>
                    </div>

                    <!-- Ticket Types Section -->
                    <div class="mt-4">
                        <h4 class="mb-3">Jenis Tiket</h4>
                        <div class="ticket-types">
                            <div class="ticket-type-item mb-3 p-3 border rounded">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Tipe Tiket</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="ticket_types[0][name]"
                                            placeholder="Regular"
                                            value="Regular"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Harga</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            name="ticket_types[0][price]"
                                            placeholder="350000"
                                            value="350000"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kuota</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            name="ticket_types[0][quota]"
                                            placeholder="500"
                                            value="500"
                                        >
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>

                            <div class="ticket-type-item mb-3 p-3 border rounded">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Tipe Tiket</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="ticket_types[1][name]"
                                            placeholder="VIP"
                                            value="VIP"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Harga</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            name="ticket_types[1][price]"
                                            placeholder="500000"
                                            value="500000"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kuota</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            name="ticket_types[1][quota]"
                                            placeholder="250"
                                            value="250"
                                        >
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary mt-2">
                            <i class="fas fa-plus"></i> Tambah Jenis Tiket
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="/admin/events" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Preview Card -->
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 150px; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-image"></i> Banner Preview
                </div>
                <h6>Konser Musik Elektro 2026</h6>
                <p class="text-muted small">Jakarta Convention Center</p>
                <p class="text-muted small">15 Agustus 2026, 18:00</p>
                <hr>
                <div class="mb-3">
                    <span class="badge bg-primary">Konser</span>
                </div>
                <h6 class="text-success">Harga Tiket</h6>
                <ul class="list-unstyled">
                    <li>Regular: Rp 350.000</li>
                    <li>VIP: Rp 500.000</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
