@extends('layouts.app')

@section('title', 'Checkout - Tiket Online')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">Ringkasan Pemesanan</h2>

            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pemesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Event:</strong> Konser Musik Elektro 2026</p>
                            <p><strong>Tanggal:</strong> 15 Agustus 2026</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Lokasi:</strong> Jakarta Convention Center</p>
                            <p><strong>Jam:</strong> 19:00 - 23:00</p>
                        </div>
                    </div>

                    <hr>

                    <h6>Rincian Tiket</h6>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>2x Regular (Rp 250.000)</td>
                                <td class="text-end">Rp 500.000</td>
                            </tr>
                            <tr>
                                <td>1x VIP (Rp 500.000)</td>
                                <td class="text-end">Rp 500.000</td>
                            </tr>
                            <tr class="table-active fw-bold">
                                <td>Subtotal</td>
                                <td class="text-end">Rp 1.000.000</td>
                            </tr>
                            <tr>
                                <td>Biaya Layanan (5%)</td>
                                <td class="text-end">Rp 50.000</td>
                            </tr>
                            <tr class="table-active fw-bold">
                                <td>Total</td>
                                <td class="text-end">Rp 1.050.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Pemesan</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="john@example.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" value="08123456789">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Identitas (KTP/Paspor)</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="col-lg-4">
            <div class="card sticky-top">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Total Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p class="h3 text-center mb-4">Rp 1.050.000</p>

                    <h6 class="mb-3">Pilih Metode Pembayaran</h6>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" id="transfer" value="transfer" checked>
                            <label class="form-check-label" for="transfer">
                                <i class="fas fa-university"></i> Transfer Bank
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" id="card" value="card">
                            <label class="form-check-label" for="card">
                                <i class="fas fa-credit-card"></i> Kartu Kredit
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" id="ewallet" value="ewallet">
                            <label class="form-check-label" for="ewallet">
                                <i class="fas fa-wallet"></i> E-Wallet
                            </label>
                        </div>
                    </div>

                    <hr>

                    <button class="btn btn-success w-100 btn-lg mb-2">
                        <i class="fas fa-lock"></i> Lanjutkan Pembayaran
                    </button>
                    <a href="/events" class="btn btn-secondary w-100">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
