@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #ffffff 0%, #ebf5ff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <h3 class="card-title fw-bold mb-2">
                            <i class="bi bi-credit-card"></i> Pembayaran Pesanan
                        </h3>
                        <p class="text-muted mb-4">Selesaikan pembayaran untuk mengkonfirmasi pesanan Anda</p>

                        <hr>

                        <!-- Order Summary -->
                        <div class="bg-light p-4 rounded mb-4">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Order ID</small>
                                    <p class="fw-bold">#{{ $pemesanan->id }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">Status</small>
                                    <p class="fw-bold">
                                        <span class="badge bg-warning">{{ ucfirst($pemesanan->status_pemesanan) }}</span>
                                    </p>
                                </div>
                            </div>

                            <hr class="my-2">

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Tanggal Mulai</small>
                                    <p class="fw-bold">{{ $pemesanan->tanggal_mulai instanceof \DateTime ? $pemesanan->tanggal_mulai->format('d/m/Y') : \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Tanggal Selesai</small>
                                    <p class="fw-bold">{{ $pemesanan->tanggal_selesai instanceof \DateTime ? $pemesanan->tanggal_selesai->format('d/m/Y') : \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <hr class="my-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Total Pembayaran</small>
                                <h4 class="fw-bold mb-0 text-primary">
                                    Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>

                        <!-- Payment Method Info -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle"></i>
                            <small>
                                Klik tombol <strong>"Bayar Sekarang"</strong> untuk membuka dialog pembayaran Midtrans.
                                <br>Anda dapat memilih berbagai metode pembayaran (Transfer Bank, E-wallet, dll).
                            </small>
                        </div>

                        <!-- Payment Button -->
                        <button id="pay-button" class="btn btn-success btn-lg w-100 fw-bold">
                            <i class="bi bi-lock"></i> Bayar Sekarang (Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }})
                        </button>

                        <!-- Cancel Option -->
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm w-100 mt-3">
                            Batal / Kembali
                        </a>

                        <!-- Security Badge -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="bi bi-shield-check"></i> 
                                Pembayaran dijamin aman oleh <strong>Midtrans</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Midtrans Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            // Pembayaran berhasil
            console.log('Payment Success:', result);
            // Redirect ke halaman success
            window.location.href = '{{ route("pemesanan.success", $pemesanan->id) }}';
        },
        onPending: function(result) {
            // Pembayaran pending
            console.log('Payment Pending:', result);
            alert('Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi.');
        },
        onError: function(result) {
            // Pembayaran gagal
            console.log('Payment Error:', result);
            // Redirect ke halaman failed
            window.location.href = '{{ route("pemesanan.failed", $pemesanan->id) }}';
        },
        onClose: function() {
            // Dialog ditutup tanpa transaksi
            console.log('Payment dialog closed');
            alert('Anda menutup dialog pembayaran. Silakan klik tombol "Bayar Sekarang" untuk melanjutkan.');
        }
    });
};
</script>
@endsection
