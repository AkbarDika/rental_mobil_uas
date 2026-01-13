@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #ffffff 0%, #ebf5ff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Success Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5 text-center">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <i class="bi bi-check-circle" style="font-size: 4rem; color: #28a745;"></i>
                        </div>

                        <!-- Title -->
                        <h2 class="card-title fw-bold mb-3" style="color: #28a745;">
                            Pembayaran Berhasil! ✅
                        </h2>

                        <!-- Message -->
                        <p class="text-muted mb-4" style="font-size: 1.1rem;">
                            Terima kasih atas pembayaran Anda. Pesanan Anda telah dikonfirmasi.
                        </p>

                        <!-- Order Details -->
                        <div class="bg-light p-4 rounded mb-4">
                            <div class="row mb-3">
                                <div class="col-6 text-start">
                                    <small class="text-muted">Order ID</small>
                                    <p class="fw-bold">#{{ $pemesanan->id }}</p>
                                </div>
                                <div class="col-6 text-start">
                                    <small class="text-muted">Tanggal Pesanan</small>
                                    <p class="fw-bold">{{ $pemesanan->tanggal_pesan instanceof \DateTime ? $pemesanan->tanggal_pesan->format('d/m/Y') : \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-6 text-start">
                                    <small class="text-muted">Tanggal Mulai Sewa</small>
                                    <p class="fw-bold">{{ $pemesanan->tanggal_mulai instanceof \DateTime ? $pemesanan->tanggal_mulai->format('d/m/Y') : \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 text-start">
                                    <small class="text-muted">Tanggal Selesai</small>
                                    <p class="fw-bold">{{ $pemesanan->tanggal_selesai instanceof \DateTime ? $pemesanan->tanggal_selesai->format('d/m/Y') : \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="text-start">
                                <small class="text-muted">Total Pembayaran</small>
                                <p class="fw-bold text-success" style="font-size: 1.5rem;">
                                    Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle"></i> <strong>Info Penting:</strong>
                            <br>
                            <small>
                                Silakan cek email Anda untuk detail lebih lanjut. 
                                Driver akan menghubungi Anda sebelum tanggal pengambilan.
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-house"></i> Kembali ke Dashboard
                            </a>
                            <a href="{{ route('user.riwayat_pesanan') }}" class="btn btn-outline-primary">
                                <i class="bi bi-shop"></i> Lihat Riwayat Transaksi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-question-circle"></i> Apa Selanjutnya?
                        </h6>
                        <ol class="mb-0">
                            <li class="mb-2">
                                <small>
                                    <strong>Konfirmasi Booking:</strong> 
                                    Admin akan mengkonfirmasi booking Anda dalam 1x24 jam
                                </small>
                            </li>
                            <li class="mb-2">
                                <small>
                                    <strong>Pengambilan Mobil:</strong> 
                                    Ambil mobil pada tanggal yang telah ditentukan
                                </small>
                            </li>
                            <li class="mb-2">
                                <small>
                                    <strong>Pengembalian:</strong> 
                                    Kembalikan mobil sesuai jadwal pengembalian
                                </small>
                            </li>
                            <li>
                                <small>
                                    <strong>Selesai:</strong> 
                                    Dapatkan pembayaran deposit kembali (jika ada denda 0)
                                </small>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
