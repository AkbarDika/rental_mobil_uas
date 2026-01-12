@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-terminal"></i> Test Midtrans Callback
                    </h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Gunakan halaman ini untuk test callback Midtrans secara manual. 
                        <strong>Hanya untuk development, hapus di production!</strong>
                    </p>

                    <form action="{{ route('test.midtrans-callback') }}" method="POST" class="needs-validation">
                        @csrf

                        <div class="mb-3">
                            <label for="pemesanan_id" class="form-label fw-bold">
                                Pilih Pemesanan
                            </label>
                            <select class="form-select" id="pemesanan_id" name="pemesanan_id" required>
                                <option value="">-- Pilih Pemesanan --</option>
                                @forelse($pemesanans as $p)
                                    <option value="{{ $p->id }}">
                                        #{{ $p->id }} - Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                        (Status: {{ $p->status }})
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada pemesanan</option>
                                @endforelse
                            </select>
                            <small class="text-muted">Pilih pemesanan yang belum dibayar</small>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_status" class="form-label fw-bold">
                                Status Transaksi
                            </label>
                            <select class="form-select" id="transaction_status" name="transaction_status" required>
                                <option value="settlement">✅ Settlement (Berhasil)</option>
                                <option value="capture">✅ Capture (Berhasil)</option>
                                <option value="pending">⏳ Pending (Menunggu Konfirmasi)</option>
                                <option value="deny">❌ Deny (Ditolak)</option>
                                <option value="cancel">❌ Cancel (Dibatalkan)</option>
                                <option value="expire">❌ Expire (Kadaluarsa)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="payment_type" class="form-label fw-bold">
                                Metode Pembayaran
                            </label>
                            <select class="form-select" id="payment_type" name="payment_type" required>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="bca_va">BCA Virtual Account</option>
                                <option value="bni_va">BNI Virtual Account</option>
                                <option value="cimb_va">CIMB Virtual Account</option>
                                <option value="permata_va">Permata Virtual Account</option>
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                            </select>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-play-circle"></i> Test Callback Sekarang
                        </button>
                    </form>

                    <div class="alert alert-info mt-4">
                        <strong>💡 Instruksi:</strong>
                        <ol>
                            <li>Pilih pemesanan yang sudah Anda buat</li>
                            <li>Pilih status transaksi (settlement = pembayaran berhasil)</li>
                            <li>Klik tombol "Test Callback"</li>
                            <li>Cek tabel pembayaran apakah data sudah terisi</li>
                        </ol>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>✅ Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>❌ Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Box -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <i class="bi bi-info-circle"></i> Tentang Webhook
                    </h5>
                    <p class="text-muted">
                        <strong>Webhook</strong> adalah notifikasi otomatis dari Midtrans ke server Anda saat pembayaran berhasil.
                        Karena Anda menggunakan localhost, Midtrans tidak bisa mengirim webhook secara otomatis.
                    </p>
                    <p class="text-muted">
                        <strong>Solusi untuk Production:</strong>
                    </p>
                    <ol class="text-muted">
                        <li>Deploy ke server dengan domain public (contoh: yoursite.com)</li>
                        <li>Buka Midtrans Dashboard → Settings → Notification URL</li>
                        <li>Masukkan: <code>https://yoursite.com/midtrans/callback</code></li>
                        <li>Midtrans akan otomatis mengirim callback setiap transaksi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
