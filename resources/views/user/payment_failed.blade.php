@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #ffffff 0%, #ebf5ff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Error Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5 text-center">
                        <!-- Error Icon -->
                        <div class="mb-4">
                            <i class="bi bi-x-circle" style="font-size: 4rem; color: #dc3545;"></i>
                        </div>

                        <!-- Title -->
                        <h2 class="card-title fw-bold mb-3" style="color: #dc3545;">
                            Pembayaran Gagal ❌
                        </h2>

                        <!-- Message -->
                        <p class="text-muted mb-4" style="font-size: 1.1rem;">
                            Pembayaran Anda tidak berhasil diproses. Silakan coba lagi atau gunakan metode pembayaran lain.
                        </p>

                        <!-- Order Details -->
                        <div class="bg-light p-4 rounded mb-4">
                            <div class="row mb-3">
                                <div class="col-12 text-start">
                                    <small class="text-muted">Order ID</small>
                                    <p class="fw-bold">#{{ $pemesanan->id }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="text-start">
                                <small class="text-muted">Total Pembayaran</small>
                                <p class="fw-bold text-danger" style="font-size: 1.5rem;">
                                    Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Penyebab Umum:</strong>
                            <br>
                            <small>
                                • Nomor kartu/rekening tidak valid<br>
                                • Saldo tidak cukup<br>
                                • Limit transaksi terlampaui<br>
                                • Transaksi dibatalkan
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('pemesanan.payment', $pemesanan->id) }}" class="btn btn-primary">
                                <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-house"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Info -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-headset"></i> Perlu Bantuan?
                        </h6>
                        <small class="text-muted">
                            Jika Anda terus mengalami masalah, silakan hubungi tim support kami:
                            <br><strong>Email:</strong> support@rental.com
                            <br><strong>WhatsApp:</strong> +62 812-3456-7890
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
