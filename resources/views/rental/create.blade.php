@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #ffffff 0%, #ebf5ff 100%);">
    <div class="container-sm">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog.show', $car->id) }}" class="text-decoration-none">{{ $car->merk }} {{ $car->model }}</a></li>
                <li class="breadcrumb-item active">Pemesanan</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Side - Informasi Mobil -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm sticky-top" style="top: 80px;">
                    <!-- Foto Mobil -->
                    <img src="{{ asset('storage/' . $car->foto) }}" alt="{{ $car->merk }} {{ $car->model }}" 
                         class="card-img-top" style="height: 250px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $car->merk }} {{ $car->model }}</h5>
                        
                        <!-- Detail Mobil -->
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-calendar"></i> {{ $car->tahun }}
                            </small>
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-people"></i> {{ $car->jumlah_kursi }} Kursi
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-fuel-pump"></i> {{ $car->jenis_bahan_bakar }}
                            </small>
                        </div>

                        <hr>

                        <!-- Harga Sewa -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Harga Per Hari</h6>
                            <h3 class="text-primary fw-bold">
                                Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}
                            </h3>
                        </div>

                        <!-- Total Estimasi (akan diupdate via JavaScript) -->
                        <div class="bg-light p-3 rounded">
                            <h6 class="text-muted mb-2">Estimasi Total</h6>
                            <h4 class="text-success fw-bold" id="totalEstimate">
                                Rp 0
                            </h4>
                            <small class="text-muted d-block mt-2" id="durationInfo">
                                Pilih tanggal untuk melihat estimasi
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form Pemesanan -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-4">
                            <i class="bi bi-calendar-check"></i> Form Pemesanan
                        </h4>

                        <form action="{{ route('rental.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <!-- Mobil ID (Hidden) -->
                            <input type="hidden" name="mobil_id" value="{{ $car->id }}">

                            <!-- Tanggal Mulai Sewa -->
                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label fw-bold">
                                    <i class="bi bi-calendar-plus"></i> Tanggal Mulai Sewa
                                </label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" required value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih tanggal awal penyewaan (minimal hari depan)</small>
                            </div>

                            <!-- Tanggal Selesai Sewa -->
                            <div class="mb-4">
                                <label for="tanggal_selesai" class="form-label fw-bold">
                                    <i class="bi bi-calendar-minus"></i> Tanggal Selesai Sewa
                                </label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" required value="{{ old('tanggal_selesai') }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih tanggal pengembalian (minimal 1 hari setelah mulai)</small>
                            </div>

                            <hr class="my-4">

                            <!-- Tombol Submit -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <i class="bi bi-check-circle"></i> Konfirmasi Pemesanan
                                </button>
                                <a href="{{ route('catalog.show', $car->id) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Syarat & Ketentuan -->
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading fw-bold">
                        <i class="bi bi-info-circle"></i> Informasi Penting
                    </h6>
                    <ul class="mb-0" style="font-size: 14px;">
                        <li>Pastikan tanggal kembali lebih besar dari tanggal sewa</li>
                        <li>Lakukan pembayaran setelah pemesanan untuk mengkonfirmasi pesanan</li>
                        <li>Syarat dan ketentuan berlaku sesuai dengan kebijakan perusahaan</li>
                        <li>Hubungi customer service untuk bantuan lebih lanjut</li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const hargaSewa = {{ $car->harga_sewa }};
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
    const totalEstimate = document.getElementById('totalEstimate');
    const durationInfo = document.getElementById('durationInfo');

    function hitungTotal() {
        const tanggalMulai = tanggalMulaiInput.value ? new Date(tanggalMulaiInput.value) : null;
        const tanggalSelesai = tanggalSelesaiInput.value ? new Date(tanggalSelesaiInput.value) : null;

        // Reset jika salah satu kosong
        if (!tanggalMulai || !tanggalSelesai) {
            totalEstimate.textContent = 'Rp 0';
            durationInfo.textContent = 'Pilih tanggal untuk melihat estimasi';
            return;
        }

        // ✅ Hitung selisih hari dengan akurat
        // Gunakan UTC untuk menghindari timezone issues
        const timeDiff = tanggalSelesai.getTime() - tanggalMulai.getTime();
        const selisihHari = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

        // ✅ Validasi: minimal 1 hari
        if (selisihHari <= 0) {
            totalEstimate.textContent = 'Rp 0';
            durationInfo.textContent = '⚠️ Tanggal kembali harus 1+ hari setelah mulai';
            durationInfo.style.color = '#dc3545'; // Red
            return;
        }

        // Reset color
        durationInfo.style.color = '#6c757d'; // Gray

        // ✅ Hitung total dengan akurat
        const total = selisihHari * hargaSewa;

        // Format harga dengan Intl.NumberFormat
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        totalEstimate.textContent = formatter.format(total);
        durationInfo.textContent = `${selisihHari} hari × Rp ${new Intl.NumberFormat('id-ID').format(hargaSewa)}`;
    }

    // Hitung total saat tanggal berubah
    tanggalMulaiInput.addEventListener('change', hitungTotal);
    tanggalSelesaiInput.addEventListener('change', hitungTotal);

    // Set minimum tanggal ke hari ini
    const today = new Date().toISOString().split('T')[0];
    tanggalMulaiInput.setAttribute('min', today);
    
    // Update min tanggal selesai ketika mulai berubah
    tanggalMulaiInput.addEventListener('change', function() {
        if (this.value) {
            // Set minimum tanggal selesai = tanggal mulai + 1 hari
            const minDate = new Date(this.value);
            minDate.setDate(minDate.getDate() + 1);
            tanggalSelesaiInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        }
    });
</script>
@endsection
